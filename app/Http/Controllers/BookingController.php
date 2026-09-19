<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Jobs\ProcessBookingNotificationJob;
use App\Models\Booking;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Form konfirmasi booking dengan validasi batas lapangan unpaid
     */
    public function create(Request $request)
    {
        $jadwalSlotId = $request->query('slot_id');
        
        if (!$jadwalSlotId) {
            return redirect()->route('home')->with('error', 'Silakan pilih jadwal terlebih dahulu.');
        }

        $slot = JadwalSlot::with('lapangan')->findOrFail($jadwalSlotId);
        $lapangan = $slot->lapangan;
        
        if (!$slot->tersedia) {
            return redirect()->route('lapangan.show', $lapangan->id)
                ->with('error', 'Maaf, jadwal ini baru saja diambil atau sudah tidak tersedia.');
        }

        // Aturan Bisnis: User tidak bisa pesan lebih dari 2 lapangan berbeda jika belum payment (status pending)
        $pendingDistinctCourtsCount = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->distinct()
            ->count('lapangan_id');

        $alreadyHasPendingForThisCourt = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('lapangan_id', $lapangan->id)
            ->exists();

        if ($pendingDistinctCourtsCount >= 2 && !$alreadyHasPendingForThisCourt) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Anda memiliki pesanan belum dibayar di ' . $pendingDistinctCourtsCount . ' lapangan berbeda. Selesaikan pembayaran atau batalkan pesanan sebelum memesan lapangan lain.');
        }

        return view('booking.create', compact('slot', 'lapangan'));
    }

    /**
     * Proses booking dengan transaction, cek bentrok, dan dispatch job notifikasi
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            DB::beginTransaction();

            $slot = JadwalSlot::where('id', $request->jadwal_slot_id)
                ->lockForUpdate()
                ->firstOrFail();

            $lapangan = Lapangan::findOrFail($request->lapangan_id);

            // Validasi ulang batas 2 lapangan berbeda pending
            $pendingDistinctCourtsCount = Booking::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->distinct()
                ->count('lapangan_id');

            $alreadyHasPendingForThisCourt = Booking::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->where('lapangan_id', $lapangan->id)
                ->exists();

            if ($pendingDistinctCourtsCount >= 2 && !$alreadyHasPendingForThisCourt) {
                DB::rollBack();
                return redirect()->route('customer.dashboard')
                    ->with('error', 'Anda memiliki pesanan belum dibayar di ' . $pendingDistinctCourtsCount . ' lapangan berbeda. Selesaikan pembayaran atau batalkan pesanan sebelum memesan lapangan lain.');
            }

            // Cek apakah slot masih tersedia
            if (!$slot->tersedia) {
                DB::rollBack();
                return redirect()->route('lapangan.show', $lapangan->id)
                    ->with('error', 'Maaf, jadwal ini sudah terisi oleh pemesan lain.');
            }

            // Cek apakah ada booking aktif di slot yang sama
            $existingBooking = Booking::where('jadwal_slot_id', $slot->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->first();

            if ($existingBooking) {
                DB::rollBack();
                return redirect()->route('lapangan.show', $lapangan->id)
                    ->with('error', 'Maaf, jadwal ini baru saja dibooking oleh orang lain.');
            }

            // Buat data pemesanan
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'lapangan_id' => $lapangan->id,
                'jadwal_slot_id' => $slot->id,
                'tanggal_booking' => $slot->tanggal,
                'jam_mulai' => $slot->jam_mulai,
                'jam_selesai' => $slot->jam_selesai,
                'total_harga' => $lapangan->harga_per_jam,
                'status' => 'pending',
                'metode_pembayaran' => $request->get('metode_pembayaran', 'qris'),
                'catatan' => $request->catatan,
            ]);

            // Kunci slot agar tidak bisa dipesan lagi
            $slot->update(['tersedia' => false]);

            DB::commit();

            // Dispatch Asynchronous Queue Job untuk pengiriman notifikasi invoice/tiket
            ProcessBookingNotificationJob::dispatch($booking);

            return redirect()->route('customer.dashboard')
                ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran sesuai metode yang dipilih.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.dashboard')
                ->with('error', 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }
    }

    /**
     * Dashboard Pelanggan & Riwayat Pemesanan
     */
    public function customerHistory()
    {
        $userId = Auth::id();

        $bookings = Booking::where('user_id', $userId)
            ->with(['lapangan', 'jadwalSlot'])
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
     * Pembatalan pemesanan mandiri oleh pelanggan (hanya jika masih pending)
     */
    public function cancel(Booking $booking)
    {
        // Pastikan hanya pemilik booking yang bisa membatalkan
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan berstatus menunggu yang dapat dibatalkan.');
        }

        try {
            DB::beginTransaction();

            $booking->update(['status' => 'cancelled']);

            // Kembalikan ketersediaan slot
            if ($booking->jadwal_slot_id) {
                JadwalSlot::where('id', $booking->jadwal_slot_id)->update(['tersedia' => true]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan jadwal telah dibuka kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
        }
    }
}
