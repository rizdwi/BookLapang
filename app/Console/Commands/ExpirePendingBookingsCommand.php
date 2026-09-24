<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\JadwalSlot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpirePendingBookingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan pesanan pending yang melewati batas waktu (15 menit) dan buka kembali ketersediaan slot.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memeriksa pesanan pending yang kadaluarsa...');

        $expiredBookings = Booking::with('bookingSlots')
            ->where('status', 'pending')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNotNull('expires_at')
                      ->where('expires_at', '<', now());
                })->orWhere(function ($q) {
                    $q->whereNull('expires_at')
                      ->where('created_at', '<', now()->subMinutes(15));
                });
            })
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('Tidak ada pesanan pending yang kadaluarsa.');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($expiredBookings as $booking) {
            DB::beginTransaction();
            try {
                $booking->update(['status' => 'cancelled']);

                // Kembalikan slot utama
                if ($booking->jadwal_slot_id) {
                    JadwalSlot::where('id', $booking->jadwal_slot_id)->update(['tersedia' => true]);
                }

                // Kembalikan semua slot terkait jika multi-slot
                foreach ($booking->bookingSlots as $item) {
                    JadwalSlot::where('id', $item->jadwal_slot_id)->update(['tersedia' => true]);
                }

                DB::commit();
                $count++;
                $this->line("Pesanan #{$booking->id} ({$booking->kode_booking}) dibatalkan otomatis karena melewati batas waktu bayar.");
                Log::info("AutoExpire: Booking #{$booking->id} ({$booking->kode_booking}) dibatalkan otomatis dan slot telah dibuka kembali.");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Gagal auto-expire booking #{$booking->id}: " . $e->getMessage());
            }
        }

        $this->info("Berhasil membatalkan {$count} pesanan kadaluarsa.");
        return Command::SUCCESS;
    }
}
