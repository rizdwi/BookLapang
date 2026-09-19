<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLapanganRequest;
use App\Models\Lapangan;
use Illuminate\Http\Request;
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
            // Hapus foto lama jika ada
            if ($lapangan->foto && Storage::disk('public')->exists($lapangan->foto)) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $path = $request->file('foto')->store('lapangan', 'public');
            $data['foto'] = $path;
        }

        $lapangan->update($data);

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->foto && Storage::disk('public')->exists($lapangan->foto)) {
            Storage::disk('public')->delete($lapangan->foto);
        }
        
        $lapangan->delete();

        return redirect()->route('admin.lapangan.index')->with('success', 'Lapangan berhasil dihapus.');
    }
}
