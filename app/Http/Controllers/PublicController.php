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

        // Ambil semua slot pada tanggal tersebut (baik yang tersedia maupun terisi)
        $jadwal_slots = JadwalSlot::where('lapangan_id', $lapangan->id)
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        return view('public.show', compact('lapangan', 'jadwal_slots', 'selectedDate'));
    }
}
