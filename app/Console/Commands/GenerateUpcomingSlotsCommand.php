<?php

namespace App\Console\Commands;

use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\LapanganTarif;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateUpcomingSlotsCommand extends Command
{
    protected $signature = 'jadwal:generate-upcoming {--days=30 : Jumlah hari ke depan yang harus tersedia}';
    protected $description = 'Pastikan setiap lapangan memiliki slot untuk N hari ke depan (self-healing jadwal)';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $today = Carbon::today();
        $end = (clone $today)->addDays($days - 1);
        $now = now();
        $created = 0;
        $skipped = 0;

        $lapangans = Lapangan::with('tarifs')->get();
        if ($lapangans->isEmpty()) {
            $this->warn('Tidak ada lapangan. Lewati.');
            return self::SUCCESS;
        }

        // Hapus slot kadaluarsa (kemarin ke belakang) agar DB tidak membengkak
        $deletedPast = JadwalSlot::whereDate('tanggal', '<', $today->format('Y-m-d'))->delete();
        if ($deletedPast > 0) {
            $this->info("Menghapus {$deletedPast} slot kadaluarsa (< hari ini).");
        }

        $batch = [];
        foreach ($lapangans as $lap) {
            $peakTarif = $lap->tarifs ? $lap->tarifs->firstWhere('aktif', true) : null;
            // Fallback query jika relasi belum loaded
            if (!$peakTarif) {
                $peakTarif = LapanganTarif::where('lapangan_id', $lap->id)->where('aktif', true)->first();
            }

            for ($d = clone $today; $d->lte($end); $d->addDay()) {
                $tanggal = $d->format('Y-m-d');

                // Jika sudah ada minimal 1 slot untuk tanggal ini, anggap sudah tergenerate
                if (JadwalSlot::where('lapangan_id', $lap->id)->whereDate('tanggal', $tanggal)->exists()) {
                    $skipped++;
                    continue;
                }

                for ($h = 8; $h < 22; $h++) {
                    $jamMulai = sprintf('%02d:00:00', $h);
                    $jamSelesai = sprintf('%02d:00:00', $h + 1);
                    $slotPrice = ($peakTarif && $jamMulai >= '18:00:00') ? $peakTarif->harga : $lap->harga_per_jam;

                    $batch[] = [
                        'lapangan_id' => $lap->id,
                        'tanggal'     => $tanggal,
                        'jam_mulai'   => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'harga'       => $slotPrice,
                        'tersedia'    => true,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];
                    $created++;

                    if (count($batch) >= 500) {
                        JadwalSlot::insert($batch);
                        $batch = [];
                    }
                }
            }
        }

        if (!empty($batch)) {
            JadwalSlot::insert($batch);
        }

        $this->info("Selesai: {$created} slot baru dibuat, {$skipped} hari/lapangan sudah ada (skip). Rentang {$today->format('Y-m-d')} s/d {$end->format('Y-m-d')}.");
        return self::SUCCESS;
    }
}
