<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Jobs\ProcessBookingNotificationJob;
use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Form konfirmasi booking dengan validasi single/multi-slot
     */
    public function create(Request $request)
    {
        // Mendukung multi slot (slot_ids) atau single slot (slot_id)
        $rawSlotIds = $request->query('slot_ids', $request->query('slot_id'));

        if (!$rawSlotIds) {
            return redirect()->route('lapangan.index')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        $slotIds = is_array($rawSlotIds) ? $rawSlotIds : explode(',', (string) $rawSlotIds);
        $slotIds = array_filter(array_map('intval', $slotIds));

        if (empty($slotIds)) {
            return redirect()->route('lapangan.index')->with('error', 'Silakan pilih minimal 1 slot jadwal.');
        }

        $slots = JadwalSlot::with('lapangan')
            ->whereIn('id', $slotIds)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        if ($slots->isEmpty()) {
            return redirect()->route('lapangan.index')->with('error', 'Slot jadwal tidak ditemukan.');
        }

        $lapangan = $slots->first()->lapangan;

        // Cek ketersediaan setiap slot
        foreach ($slots as $slot) {
            if (!$slot->tersedia) {
                return redirect()->route('lapangan.show', $lapangan->id)
                    ->with('error', "Jadwal jam {$slot->jam_mulai} baru saja diambil atau sudah tidak tersedia.");
            }
        }

        // Aturan Bisnis: Max 2 pesanan pending — selesaikan pembayaran dulu
        $pendingCount = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        if ($pendingCount >= 2) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Anda sudah memiliki ' . $pendingCount . ' pesanan yang belum dibayar. Selesaikan pembayaran atau batalkan pesanan lama sebelum membuat pesanan baru.');
        }

        // Hitung total harga
        $totalHarga = $slots->sum(function ($slot) {
            return $slot->harga_efektif;
        });

        $primarySlot = $slots->first();

        return view('booking.create', compact('slots', 'primarySlot', 'lapangan', 'totalHarga'));
    }

    /**
     * Proses booking dengan transaction, multi-slot locking, auto-expire TTL, dan notifikasi
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = null;

        $rawSlotIds = $request->jadwal_slot_ids ?? $request->jadwal_slot_id;
        $slotIds = is_array($rawSlotIds) ? $rawSlotIds : explode(',', (string) $rawSlotIds);
        $slotIds = array_values(array_filter(array_map('intval', $slotIds)));

        if (empty($slotIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu slot jadwal.');
        }

        try {
            DB::beginTransaction();

            $lapangan = Lapangan::findOrFail($request->lapangan_id);

            // Validasi ulang: max 2 pesanan pending total
            $pendingCount = Booking::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->count();

            if ($pendingCount >= 2) {
                DB::rollBack();
                return redirect()->route('customer.dashboard')
                    ->with('error', 'Anda sudah memiliki ' . $pendingCount . ' pesanan yang belum dibayar. Selesaikan pembayaran atau batalkan pesanan lama sebelum membuat pesanan baru.');
            }

            // Lock semua slot yang diminta
            $slots = JadwalSlot::whereIn('id', $slotIds)
                ->where('lapangan_id', $lapangan->id)
                ->lockForUpdate()
                ->orderBy('jam_mulai')
                ->get();

            if ($slots->count() !== count($slotIds)) {
                DB::rollBack();
                return redirect()->route('lapangan.show', $lapangan->id)
                    ->with('error', 'Sebagian slot jadwal tidak ditemukan atau tidak valid.');
            }

            // Cek ketersediaan seluruh slot
            foreach ($slots as $slot) {
                if (!$slot->tersedia) {
                    DB::rollBack();
                    return redirect()->route('lapangan.show', $lapangan->id)
                        ->with('error', "Jadwal jam " . substr($slot->jam_mulai, 0, 5) . " sudah terisi oleh pemesan lain.");
                }
            }

            // Cek apakah ada booking aktif (pending/confirmed) di slot-slot tersebut
            $existingCount = DB::table('booking_slots')
                ->join('bookings', 'booking_slots.booking_id', '=', 'bookings.id')
                ->whereIn('booking_slots.jadwal_slot_id', $slotIds)
                ->whereIn('bookings.status', ['pending', 'confirmed'])
                ->count();

            if ($existingCount > 0) {
                DB::rollBack();
                return redirect()->route('lapangan.show', $lapangan->id)
                    ->with('error', 'Maaf, salah satu jadwal baru saja dibooking oleh orang lain.');
            }

            // Hitung total harga & rentang jam
            $totalHarga = 0;
            $slotDetails = [];
            foreach ($slots as $slot) {
                $price = $slot->harga_efektif;
                $totalHarga += $price;
                $slotDetails[] = [
                    'slot' => $slot,
                    'price' => $price,
                ];
            }

            $firstSlot = $slots->first();
            $lastSlot = $slots->last();

            // Generate Kode Unik: BK-YYMMDD-XXXX
            $datePrefix = date('ymd');
            $randomSuffix = strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
            $kodeBooking = "BK-{$datePrefix}-{$randomSuffix}";

            // Buat data pemesanan utama
            $booking = Booking::create([
                'kode_booking' => $kodeBooking,
                'user_id' => Auth::id(),
                'lapangan_id' => $lapangan->id,
                'jadwal_slot_id' => $firstSlot->id,
                'tanggal_booking' => $firstSlot->tanggal,
                'jam_mulai' => $firstSlot->jam_mulai,
                'jam_selesai' => $lastSlot->jam_selesai,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'metode_pembayaran' => $request->get('metode_pembayaran', 'qris'),
                'catatan' => $request->catatan,
                'expires_at' => now()->addMinutes(15), // Auto-expire TTL 15 menit
            ]);

            // Catat masing-masing slot ke tabel pivot booking_slots & kunci ketersediaan
            foreach ($slotDetails as $detail) {
                BookingSlot::create([
                    'booking_id' => $booking->id,
                    'jadwal_slot_id' => $detail['slot']->id,
                    'harga' => $detail['price'],
                ]);

                $detail['slot']->update(['tersedia' => false]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.dashboard')
                ->with('error', 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage());
        }

        // Dispatch notifikasi secara asinkron
        try {
            ProcessBookingNotificationJob::dispatch($booking);
        } catch (\Exception $e) {
            // Queue fallback
        }

        return redirect()->route('customer.dashboard')
            ->with('success', "Booking #{$booking->kode_booking} berhasil dibuat! Selesaikan pembayaran dalam 15 menit sebelum slot dirilis kembali.");
    }

    /**
     * Dashboard Pelanggan & Riwayat Pemesanan
     */
    public function customerHistory()
    {
        $userId = Auth::id();

        $bookings = Booking::where('user_id', $userId)
            ->with(['lapangan', 'jadwalSlot', 'bookingSlots.jadwalSlot'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $doneBookings = $bookings->where('status', 'done')->count();

        return view('customer.dashboard', compact(
            'bookings',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'doneBookings'
        ));
    }

    /**
     * Tampilan E-Ticket Digital Customer
     */
    public function ticket(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        $booking->load(['lapangan', 'jadwalSlot', 'bookingSlots.jadwalSlot', 'user']);

        return view('customer.ticket', compact('booking'));
    }

    /**
     * Pembatalan pemesanan mandiri oleh pelanggan (hanya jika masih pending)
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan berstatus menunggu yang dapat dibatalkan.');
        }

        try {
            DB::beginTransaction();

            $booking->update(['status' => 'cancelled']);

            // Kembalikan ketersediaan slot utama
            if ($booking->jadwal_slot_id) {
                JadwalSlot::where('id', $booking->jadwal_slot_id)->update(['tersedia' => true]);
            }

            // Kembalikan semua slot terkait
            foreach ($booking->bookingSlots as $bSlot) {
                JadwalSlot::where('id', $bSlot->jadwal_slot_id)->update(['tersedia' => true]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan jadwal telah dibuka kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
        }
    }
}
