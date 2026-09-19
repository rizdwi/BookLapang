<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Lapangan $lapangan)
    {
        $jadwalSlots = $lapangan->jadwalSlots()->orderBy('tanggal', 'desc')->orderBy('jam_mulai')->get();
        return view('admin.jadwal.index', compact('lapangan', 'jadwalSlots'));
    }

    public function generate(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'durasi' => 'required|integer|min:30', // dalam menit
        ]);

        $tanggal = $request->tanggal;
        $mulai = \Carbon\Carbon::createFromFormat('H:i', $request->jam_mulai);
        $selesai = \Carbon\Carbon::createFromFormat('H:i', $request->jam_selesai);
        $durasi = $request->durasi;

        $count = 0;
        
        while ($mulai < $selesai) {
            $slotSelesai = (clone $mulai)->addMinutes($durasi);
            
            if ($slotSelesai > $selesai) {
                break;
            }

            // Hindari duplikat
            $exists = JadwalSlot::where('lapangan_id', $lapangan->id)
                ->where('tanggal', $tanggal)
                ->where('jam_mulai', $mulai->format('H:i:s'))
                ->exists();

            if (!$exists) {
                JadwalSlot::create([
                    'lapangan_id' => $lapangan->id,
                    'tanggal' => $tanggal,
                    'jam_mulai' => $mulai->format('H:i:s'),
                    'jam_selesai' => $slotSelesai->format('H:i:s'),
                    'tersedia' => true,
                ]);
                $count++;
            }

            $mulai->addMinutes($durasi);
        }

        return redirect()->route('admin.lapangan.jadwal.index', $lapangan->id)
            ->with('success', "Berhasil membuat {$count} slot jadwal.");
    }

    public function toggle(JadwalSlot $slot)
    {
        $slot->update(['tersedia' => !$slot->tersedia]);
        return redirect()->back()->with('success', 'Status ketersediaan jadwal diubah.');
    }
    
    public function destroy(JadwalSlot $slot)
    {
        $slot->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
