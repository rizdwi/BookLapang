<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\Booking;
use App\Models\JadwalSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'lapangan', 'jadwalSlot', 'bookingSlots.jadwalSlot'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('lapangan', function ($lq) use ($search) {
                      $lq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.booking.index', compact('bookings'));
    }

    public function updateStatus(UpdateBookingStatusRequest $request, Booking $booking)
    {
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            $booking->update(['status' => $newStatus]);

            // Dapatkan seluruh ID slot terkait (single slot & multi-slot)
            $slotIds = $booking->bookingSlots->pluck('jadwal_slot_id')->toArray();
            if ($booking->jadwal_slot_id && !in_array($booking->jadwal_slot_id, $slotIds)) {
                $slotIds[] = $booking->jadwal_slot_id;
            }

            // Jika dibatalkan, kembalikan seluruh slot jadwal menjadi tersedia
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                if (!empty($slotIds)) {
                    JadwalSlot::whereIn('id', $slotIds)->update(['tersedia' => true]);
                }
            }

            // Jika sebelumnya dibatalkan namun diubah menjadi pending/confirmed/done, set slot tidak tersedia
            if ($oldStatus === 'cancelled' && in_array($newStatus, ['pending', 'confirmed', 'done'])) {
                if (!empty($slotIds)) {
                    JadwalSlot::whereIn('id', $slotIds)->update(['tersedia' => false]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui status booking.');
        }

        return redirect()->back()->with('success', "Status booking #{$booking->kode_booking} berhasil diperbarui menjadi {$newStatus}.");
    }

    /**
     * Export Laporan Pemesanan & Keuangan dalam format CSV (Kompatibel Excel)
     */
    public function export(Request $request): StreamedResponse
    {
        $status = $request->get('status');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Booking::with(['user', 'lapangan', 'bookingSlots.jadwalSlot'])->latest();

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal_booking', [$startDate, $endDate]);
        }

        $bookings = $query->get();

        $filename = 'Laporan_BookLapang_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Microsoft Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Kolom
            fputcsv($handle, [
                'Kode Booking',
                'Nama Pemesan',
                'Email',
                'No HP',
                'Nama Lapangan',
                'Tipe Olahraga',
                'Tanggal Main',
                'Jam Mulai',
                'Jam Selesai',
                'Jumlah Jam',
                'Total Tarif (IDR)',
                'Metode Pembayaran',
                'Status',
                'Tanggal Transaksi',
            ]);

            foreach ($bookings as $b) {
                $durasi = $b->bookingSlots->count() > 0 ? $b->bookingSlots->count() : 1;
                fputcsv($handle, [
                    $b->kode_booking ?? ('#BK-' . $b->id),
                    $b->user->name ?? '-',
                    $b->user->email ?? '-',
                    $b->user->no_hp ?? '-',
                    $b->lapangan->nama ?? '-',
                    strtoupper($b->lapangan->tipe ?? '-'),
                    $b->tanggal_booking ? Carbon::parse($b->tanggal_booking)->format('Y-m-d') : '-',
                    substr($b->jam_mulai, 0, 5),
                    substr($b->jam_selesai, 0, 5),
                    $durasi . ' Jam',
                    $b->total_harga,
                    strtoupper($b->metode_pembayaran ?? 'qris'),
                    strtoupper($b->status),
                    $b->created_at ? $b->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Halaman Check-in Kasir / Scanner Tiket Lapangan
     */
    public function checkInView(Request $request)
    {
        $code = $request->get('code');
        $foundBooking = null;

        if (!empty($code)) {
            $cleanCode = trim($code);
            $foundBooking = Booking::with(['user', 'lapangan', 'bookingSlots.jadwalSlot'])
                ->where('kode_booking', $cleanCode)
                ->orWhere('id', str_replace(['#', 'BK-', 'bk-'], '', $cleanCode))
                ->first();
        }

        return view('admin.booking.checkin', compact('foundBooking', 'code'));
    }

    /**
     * Konfirmasi Check-in pemain saat tiba di lokasi (Ubah status ke 'done')
     */
    public function checkInProcess(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibatalkan dan tidak valid untuk check-in.');
        }

        if ($booking->status === 'done') {
            return redirect()->back()->with('info', "Pesanan #{$booking->kode_booking} sudah pernah di-check-in sebelumnya.");
        }

        $booking->update(['status' => 'done']);

        return redirect()->route('admin.checkin.view', ['code' => $booking->kode_booking])
            ->with('success', "Check-in berhasil! Pemain untuk pesanan #{$booking->kode_booking} terverifikasi.");
    }
}
