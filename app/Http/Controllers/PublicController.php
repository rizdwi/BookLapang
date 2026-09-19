<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Tampilkan halaman utama dengan daftar lapangan yang aktif.
     */
    public function index()
    {
        $lapangan = Lapangan::aktif()->latest()->get();
        
        return view('welcome', compact('lapangan'));
    }

    /**
     * Tampilkan detail lapangan beserta slot jadwal yang tersedia.
     */
    public function show($id)
    {
        $lapangan = Lapangan::aktif()->with(['jadwalSlots' => function($query) {
            $query->tersedia()->where('tanggal', '>=', now()->toDateString())->orderBy('tanggal')->orderBy('jam_mulai');
        }])->findOrFail($id);
        
        // Mengelompokkan slot berdasarkan tanggal agar mudah ditampilkan di UI
        $jadwalPerTanggal = $lapangan->jadwalSlots->groupBy(function ($slot) {
            return $slot->tanggal->format('Y-m-d');
        });

        return view('lapangan.show', compact('lapangan', 'jadwalPerTanggal'));
    }
}
