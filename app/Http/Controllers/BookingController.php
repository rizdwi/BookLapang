<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Form konfirmasi booking
     */
    public function create(Request $request)
    {
        $jadwalSlotId = $request->query('slot_id');
        $slot = JadwalSlot::with('lapangan')->findOrFail($jadwalSlotId);
        
        if (!$slot->tersedia) {
            return redirect()->back()->with('error', 'Jadwal ini sudah tidak tersedia.');
        }

        return view('booking.create', compact('slot'));
    }

    /**
     * Proses booking dengan transaction dan cek bentrok
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            DB::beginTransaction();

            $slot = JadwalSlot::findOrFail($request->jadwal_slot_id);
            $lapangan = Lapangan::findOrFail($request->lapangan_id);

            // Cek apakah ada booking yang pending atau confirmed di slot yang sama
            $existingBooking = Booking::where('jadwal_slot_id', $slot->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate()
                ->first();

            if ($existingBooking) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Maaf, jadwal ini baru saja dibooking oleh orang lain.');
            }

            // Buat booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'lapangan_id' => $lapangan->id,
                'jadwal_slot_id' => $slot->id,
                'tanggal_booking' => $slot->tanggal,
                'jam_mulai' => $slot->jam_mulai,
                'jam_selesai' => $slot->jam_selesai,
                'total_harga' => $lapangan->harga_per_jam,
                'status' => 'pending',
                'catatan' => $request->catatan,
            ]);

            // Set slot menjadi tidak tersedia (jika mau sistem lock langsung)
            // Namun biasanya dibiarkan jika masih pending, tergantung bisnis logic.
            // Di sini kita lock slotnya
            $slot->update(['tersedia' => false]);

            DB::commit();

            return redirect()->route('booking.history')->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    /**
     * Lihat riwayat booking milik user sendiri
     */
    public function customerHistory()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['lapangan', 'jadwalSlot'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.history', compact('bookings'));
    }
}
