<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLapanganRequest;
use App\Models\Lapangan;
use App\Models\LapanganTarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::with('tarifs')->latest()->get();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(StoreLapanganRequest $request)
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('lapangan', 'public');
            $data['foto'] = $path;
        }

        Lapangan::create($data);

        $this->invalidateCatalogCache();

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(StoreLapanganRequest $request, Lapangan $lapangan)
    {
        $data = $request->validated();
        $data['aktif'] = $request->boolean('aktif');

        if ($request->hasFile('foto')) {
            if ($lapangan->foto && Storage::disk('public')->exists($lapangan->foto)) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $path = $request->file('foto')->store('lapangan', 'public');
            $data['foto'] = $path;
        }

        $lapangan->update($data);

        $this->invalidateCatalogCache();

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->foto && Storage::disk('public')->exists($lapangan->foto)) {
            Storage::disk('public')->delete($lapangan->foto);
        }
        
        $lapangan->delete();

        $this->invalidateCatalogCache();

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }

    /**
     * Halaman Kelola Tarif Dinamis (Peak / Weekend) untuk Lapangan
     */
    public function tarifsIndex(Lapangan $lapangan)
    {
        $tarifs = $lapangan->tarifs()->latest()->get();
        return view('admin.lapangan.tarifs', compact('lapangan', 'tarifs'));
    }

    /**
     * Simpan Aturan Tarif Dinamis Baru
     */
    public function tarifsStore(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'label' => 'nullable|string|max:100',
            'tipe_hari' => 'required|in:weekday,weekend,all',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'harga' => 'required|integer|min:1000',
        ]);

        LapanganTarif::create([
            'lapangan_id' => $lapangan->id,
            'label' => $request->label ?? 'Tarif Khusus',
            'tipe_hari' => $request->tipe_hari,
            'jam_mulai' => $request->jam_mulai . ':00',
            'jam_selesai' => $request->jam_selesai . ':00',
            'harga' => $request->harga,
            'aktif' => true,
        ]);

        $this->invalidateCatalogCache();

        return redirect()->back()->with('success', 'Skema tarif khusus berhasil ditambahkan.');
    }

    /**
     * Hapus Skema Tarif Dinamis
     */
    public function tarifsDestroy(LapanganTarif $tarif)
    {
        $tarif->delete();
        $this->invalidateCatalogCache();
        return redirect()->back()->with('success', 'Skema tarif berhasil dihapus.');
    }

    /**
     * Invalidate catalog cache to maintain cache consistency
     */
    private function invalidateCatalogCache()
    {
        $categories = ['semua', 'futsal', 'badminton', 'basket', 'tenis', 'voli'];
        foreach ($categories as $cat) {
            Cache::forget('catalog_lapangan_' . $cat);
        }
    }
}
