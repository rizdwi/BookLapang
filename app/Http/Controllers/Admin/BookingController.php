<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\Booking;
use App\Models\JadwalSlot;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'lapangan'])->latest()->get();
        return view('admin.booking.index', compact('bookings'));
    }

    public function updateStatus(UpdateBookingStatusRequest $request, Booking $booking)
    {
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        $booking->update(['status' => $newStatus]);

        // Jika dibatalkan, kembalikan slot jadwal menjadi tersedia
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            JadwalSlot::where('id', $booking->jadwal_slot_id)->update(['tersedia' => true]);
        }

        // Jika sebelumnya dibatalkan namun diubah menjadi pending/confirmed, set slot tidak tersedia
        if ($oldStatus === 'cancelled' && in_array($newStatus, ['pending', 'confirmed'])) {
             JadwalSlot::where('id', $booking->jadwal_slot_id)->update(['tersedia' => false]);
        }

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
