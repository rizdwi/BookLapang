<?php

namespace App\Http\Controllers;

use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    /**
     * Halaman Landing Page (Edukasi, Penjelasan Sistem, Keunggulan & CTA).
     */
    public function landing()
    {
        $totalLapangan = Cache::remember('landing_total_lapangan', 300, function () {
            return Lapangan::aktif()->count();
        });

        // Contoh lapangan unggulan untuk preview hero
        $featuredLapangan = Cache::remember('landing_featured_lapangan', 300, function () {
            return Lapangan::aktif()->first();
        });

        return view('public.landing', compact('totalLapangan', 'featuredLapangan'));
    }

    /**
     * Halaman Khusus Katalog & Pemesanan Lapangan (Terpisah dari Landing Page).
     * Dilengkapi filter pencarian Tipe, Tanggal Main, dan Jam Kosong.
     */
    public function catalog(Request $request)
    {
        $tipeAktif = $request->get('tipe', 'semua');
        $lokasiAktif = $request->get('lokasi', 'semua');
        $search = $request->get('q');
        $filterTanggal = $request->get('tanggal');
        $filterJam = $request->get('jam');

        $query = Lapangan::aktif()->with('tarifs');

        if ($tipeAktif !== 'semua') {
            $query->where('tipe', $tipeAktif);
        }

        if ($lokasiAktif !== 'semua' && !empty($lokasiAktif)) {
            $query->where('alamat', 'like', "%{$lokasiAktif}%");
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Self-healing katalog: jika filter tanggal dipakai tapi slot belum ada, generate dulu (tanpa menunggu cron)
        if (!empty($filterTanggal)) {
            $this->ensureAllSlotsForDate($filterTanggal);
        }

        // Filter berdasarkan tanggal dan/atau jam ketersediaan slot kosong
        if (!empty($filterTanggal) || !empty($filterJam)) {
            $query->whereHas('jadwalSlots', function ($slotQuery) use ($filterTanggal, $filterJam) {
                $slotQuery->where('tersedia', true);

                if (!empty($filterTanggal)) {
                    $slotQuery->whereDate('tanggal', $filterTanggal);
                }

                if (!empty($filterJam)) {
                    $slotQuery->whereTime('jam_mulai', '<=', $filterJam)
                              ->whereTime('jam_selesai', '>', $filterJam);
                }
            });
        }

        $lapangan = $query->latest()->get();

        return view('public.catalog', compact(
            'lapangan', 
            'tipeAktif', 
            'lokasiAktif',
            'search', 
            'filterTanggal', 
            'filterJam'
        ));
    }

    /**
     * Alias method index untuk backward compatibility jika diperlukan
     */
    public function index(Request $request)
    {
        return $this->landing();
    }

    /**
     * Tampilkan detail lapangan beserta slot jadwal untuk tanggal yang dipilih.
     */
    public function show(Request $request, $id)
    {
        $lapangan = Lapangan::aktif()->with('tarifs')->findOrFail($id);

        // Tanggal yang dipilih (default hari ini)
        $selectedDate = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        // Self-healing: jika slot untuk tanggal ini belum ada, generate on-demand (tanpa menunggu seeder/cron)
        $this->ensureSlotsFor($lapangan, $selectedDate);

        // Ambil semua slot pada tanggal tersebut (baik yang tersedia maupun terisi)
        $jadwal_slots = JadwalSlot::where('lapangan_id', $lapangan->id)
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        return view('public.show', compact('lapangan', 'jadwal_slots', 'selectedDate'));
    }

    /**
     * Self-healing jadwal: generate 08:00-22:00 jika tanggal tersebut kosong untuk lapangan ini.
     * Murah (14 inserts) dan idempotent — hanya jalan saat data hilang (deploy lama / tanggal melompat).
     */
    private function ensureSlotsFor(Lapangan $lapangan, string $tanggal): void
    {
        if (JadwalSlot::where('lapangan_id', $lapangan->id)->whereDate('tanggal', $tanggal)->exists()) {
            return;
        }

        // Validasi tanggal tidak kadaluarsa jauh & tidak terlalu jauh ke depan
        try {
            $d = Carbon::parse($tanggal);
            if ($d->lt(Carbon::today()) || $d->gt(Carbon::today()->addDays(60))) {
                return;
            }
        } catch (\Throwable $e) {
            return;
        }

        $peakTarif = $lapangan->tarifs ? $lapangan->tarifs->firstWhere('aktif', true) : null;
        if (!$peakTarif) {
            $peakTarif = \App\Models\LapanganTarif::where('lapangan_id', $lapangan->id)->where('aktif', true)->first();
        }
        $defaultPrice = $lapangan->harga_per_jam;
        $now = now();
        $batch = [];
        for ($h = 8; $h < 22; $h++) {
            $jamMulai = sprintf('%02d:00:00', $h);
            $jamSelesai = sprintf('%02d:00:00', $h + 1);
            $slotPrice = ($peakTarif && $jamMulai >= '18:00:00') ? $peakTarif->harga : $defaultPrice;
            $batch[] = [
                'lapangan_id' => $lapangan->id,
                'tanggal'     => $tanggal,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'harga'       => $slotPrice,
                'tersedia'    => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        try {
            JadwalSlot::insert($batch);
        } catch (\Throwable $e) {
            // race: slot sudah dibuat request lain
        }
    }

    /**
     * Self-healing untuk katalog: pastikan semua lapangan punya slot di tanggal filter.
     * Dipanggil saat user filter tanggal di /lapangan?tanggal=YYYY-MM-DD
     */
    private function ensureAllSlotsForDate(string $tanggal): void
    {
        try {
            $d = Carbon::parse($tanggal);
            if ($d->lt(Carbon::today()) || $d->gt(Carbon::today()->addDays(60))) {
                return;
            }
        } catch (\Throwable $e) {
            return;
        }

        // Jika sudah ada slot untuk tanggal ini (lapangan manapun), skip — hemat query
        if (JadwalSlot::whereDate('tanggal', $tanggal)->exists()) {
            // Tetap cek apakah ada lapangan yang belum punya slot di tanggal ini (misal lapangan baru)
            $lapanganIds = Lapangan::aktif()->pluck('id');
            $existingIds = JadwalSlot::whereDate('tanggal', $tanggal)->distinct()->pluck('lapangan_id');
            $missingIds = $lapanganIds->diff($existingIds);
            if ($missingIds->isEmpty()) {
                return;
            }
            $lapangans = Lapangan::with('tarifs')->whereIn('id', $missingIds)->get();
        } else {
            $lapangans = Lapangan::with('tarifs')->aktif()->get();
        }

        $now = now();
        $batch = [];
        foreach ($lapangans as $lap) {
            $peakTarif = $lap->tarifs ? $lap->tarifs->firstWhere('aktif', true) : null;
            if (!$peakTarif) {
                $peakTarif = \App\Models\LapanganTarif::where('lapangan_id', $lap->id)->where('aktif', true)->first();
            }
            $defaultPrice = $lap->harga_per_jam;
            for ($h = 8; $h < 22; $h++) {
                $jamMulai = sprintf('%02d:00:00', $h);
                $jamSelesai = sprintf('%02d:00:00', $h + 1);
                $slotPrice = ($peakTarif && $jamMulai >= '18:00:00') ? $peakTarif->harga : $defaultPrice;
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
            }
        }
        if (!empty($batch)) {
            try {
                JadwalSlot::insert($batch);
            } catch (\Throwable $e) {
                // race
            }
        }
    }
}
