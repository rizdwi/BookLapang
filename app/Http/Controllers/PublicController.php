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
     * Tampilkan halaman utama dengan daftar lapangan aktif dan in-memory caching.
     */
    public function index(Request $request)
    {
        $tipeAktif = $request->get('tipe', 'semua');
        $cacheKey = 'catalog_lapangan_' . $tipeAktif;

        // In-Memory Caching (TTL: 5 menit / 300 detik) untuk respon instan
        $lapangan = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Lapangan::aktif();

            if ($request->filled('tipe')) {
                $query->where('tipe', $request->tipe);
            }

            return $query->latest()->get();
        });

        return view('public.index', compact('lapangan', 'tipeAktif'));
    }

    /**
     * Tampilkan detail lapangan beserta slot jadwal untuk tanggal yang dipilih.
     */
    public function show(Request $request, $id)
    {
        $lapangan = Lapangan::aktif()->findOrFail($id);

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
