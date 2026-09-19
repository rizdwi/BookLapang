<?php

namespace App\Jobs;

use App\Models\Booking;
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
     * Diproses secara asinkron melalui antrean (Task Queue) untuk mencegah latency pada response HTTP.
     */
    public function handle(): void
    {
        // Simulasi pengiriman bukti invoice & notifikasi instan (Email / WhatsApp Gateway)
        Log::info("Asynchronous Queue Process: Mengirimkan tiket reservasi #BK-{$this->booking->id} kepada {$this->booking->user->name} ({$this->booking->user->email}) untuk lapangan {$this->booking->lapangan->nama}.");
    }
}
