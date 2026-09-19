<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLapanganRequest;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::latest()->get();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(StoreLapanganRequest $request)
    {
        $data = $request->validated();
        $data['aktif'] = $request->has('aktif') ? true : false;

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
        $data['aktif'] = $request->has('aktif') ? true : false;

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
