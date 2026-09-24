<?php

namespace App\Jobs;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessBookingNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new job instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->booking->load(['user', 'lapangan', 'bookingSlots.jadwalSlot']);

        $user = $this->booking->user;
        $lapangan = $this->booking->lapangan;
        $tgl = Carbon::parse($this->booking->tanggal_booking)->translatedFormat('l, d F Y');
        $jam = substr($this->booking->jam_mulai, 0, 5) . ' - ' . substr($this->booking->jam_selesai, 0, 5) . ' WIB';
        $totalFormatted = 'Rp ' . number_format($this->booking->total_harga, 0, ',', '.');
        $kode = $this->booking->kode_booking ?? ('#BK-' . $this->booking->id);

        // Template Notifikasi WhatsApp Resmi
        $waMessage = "⚽ *KONFIRMASI BOOKING - BOOKLAPANG* ⚽\n\n"
            . "Halo *{$user->name}*,\n"
            . "Pesanan lapangan olahraga Anda telah tercatat dengan detail berikut:\n\n"
            . "📋 *Kode Booking:* `{$kode}`\n"
            . "🏟️ *Lapangan:* {$lapangan->nama} ({$lapangan->tipe})\n"
            . "📅 *Tanggal:* {$tgl}\n"
            . "⏰ *Waktu:* {$jam}\n"
            . "💰 *Total Biaya:* {$totalFormatted}\n"
            . "💳 *Metode:* " . strtoupper($this->booking->metode_pembayaran) . "\n"
            . "⚡ *Status:* " . strtoupper($this->booking->status) . "\n\n"
            . "Mohon simpan kode booking atau tiket digital ini untuk ditunjukkan kepada petugas venue saat check-in.\n\n"
            . "Terima kasih telah berolahraga bersama BookLapang!";

        Log::info("WhatsApp Gateway Dispatch to {$user->email} / {$user->name}:\n" . $waMessage);
    }
}
