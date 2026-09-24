<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSlot;
use App\Models\Lapangan;
use App\Models\LapanganTarif;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Halaman kelola jadwal per-lapangan
     */
    public function index(Request $request, Lapangan $lapangan)
    {
        return redirect()->route('admin.jadwal.index', ['lapangan_id' => $lapangan->id]);
    }

    /**
     * Halaman kelola jadwal global (semua lapangan)
     */
    public function all(Request $request)
    {
        $lapanganList = Lapangan::aktif()->get();
        $selectedLapanganId = $request->get('lapangan_id', $lapanganList->first()?->id);
        $selectedDate = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        $query = JadwalSlot::with('lapangan')->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc');

        if ($selectedLapanganId) {
            $query->where('lapangan_id', $selectedLapanganId);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $selectedDate);
        }

        $jadwal = $query->paginate(25)->withQueryString();

        return view('admin.jadwal.index', compact('lapanganList', 'selectedLapanganId', 'selectedDate', 'jadwal'));
    }

    /**
     * Generate slot untuk satu lapangan tertentu
     */
    public function generate(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'durasi' => 'required|integer|min:30', // menit
        ]);

        $count = $this->createSlots(
            $lapangan->id,
            $request->tanggal,
            $request->jam_mulai,
            $request->jam_selesai,
            $request->durasi
        );

        return redirect()->back()
            ->with('success', "Berhasil membuat {$count} slot jadwal untuk {$lapangan->nama}.");
    }

    /**
     * Generate slot massal dengan rentang tanggal
     */
    public function generateBulk(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'durasi' => 'nullable|integer|min:30',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_selesai);

        $jamMulai = $request->get('jam_mulai', '08:00');
        $jamSelesai = $request->get('jam_selesai', '23:00');
        $durasi = $request->get('durasi', 60);

        $totalCount = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $totalCount += $this->createSlots(
                $lapangan->id,
                $date->format('Y-m-d'),
                $jamMulai,
                $jamSelesai,
                $durasi
            );
        }

        return redirect()->back()
            ->with('success', "Berhasil men-generate total {$totalCount} slot jadwal untuk {$lapangan->nama}.");
    }

    /**
     * Helper privat pembuatan slot dengan kalkulasi Dynamic Pricing
     */
    private function createSlots($lapanganId, $tanggal, $jamMulaiStr, $jamSelesaiStr, $durasiMenit)
    {
        if ($jamSelesaiStr === '24:00') {
            $jamSelesaiStr = '00:00';
        }
        if ($jamMulaiStr === '24:00') {
            $jamMulaiStr = '00:00';
        }

        $mulai = Carbon::createFromFormat('H:i', $jamMulaiStr);
        $selesai = Carbon::createFromFormat('H:i', $jamSelesaiStr);

        // Jika jam_selesai <= jam_mulai (misal 08:00 - 00:00), berarti jam_selesai adalah midnight
        if ($selesai <= $mulai) {
            $selesai->addDay();
        }

        $carbonTanggal = Carbon::parse($tanggal);
        $isWeekend = $carbonTanggal->isWeekend();
        $tipeHari = $isWeekend ? 'weekend' : 'weekday';

        // Ambil aturan tarif dinamis lapangan jika ada
        $tarifs = LapanganTarif::where('lapangan_id', $lapanganId)
            ->where('aktif', true)
            ->whereIn('tipe_hari', ['all', $tipeHari])
            ->get();

        $lapangan = Lapangan::find($lapanganId);
        $defaultPrice = $lapangan ? $lapangan->harga_per_jam : 0;

        $count = 0;

        while ($mulai < $selesai) {
            $slotSelesai = (clone $mulai)->addMinutes($durasiMenit);
            if ($slotSelesai > $selesai) {
                break;
            }

            $mulaiFormatted = $mulai->format('H:i:s');
            $selesaiFormatted = $slotSelesai->format('H:i:s');

            $exists = JadwalSlot::where('lapangan_id', $lapanganId)
                ->whereDate('tanggal', $tanggal)
                ->where('jam_mulai', $mulaiFormatted)
                ->exists();

            if (!$exists) {
                // Tentukan harga slot berdasarkan tarif dinamis atau default
                $slotPrice = $defaultPrice;
                foreach ($tarifs as $trf) {
                    if ($mulaiFormatted >= $trf->jam_mulai && $mulaiFormatted < $trf->jam_selesai) {
                        $slotPrice = $trf->harga;
                        break;
                    }
                }

                try {
                    JadwalSlot::create([
                        'lapangan_id' => $lapanganId,
                        'tanggal' => $tanggal,
                        'jam_mulai' => $mulaiFormatted,
                        'jam_selesai' => $selesaiFormatted,
                        'tersedia' => true,
                        'harga' => $slotPrice,
                    ]);
                    $count++;
                } catch (\Illuminate\Database\UniqueConstraintViolationException |\Illuminate\Database\QueryException $e) {
                    // Abaikan jika slot jadwal sudah ada (duplikat)
                }
            }

            $mulai->addMinutes($durasiMenit);
        }

        return $count;
    }

    /**
     * Toggle status ketersediaan slot (Buka / Tutup manual)
     */
    public function toggle(JadwalSlot $slot)
    {
        $slot->update(['tersedia' => !$slot->tersedia]);
        $statusText = $slot->tersedia ? 'dibuka kembali' : 'ditutup manual';
        return redirect()->back()->with('success', "Slot jadwal {$slot->jam_mulai} {$statusText}.");
    }

    /**
     * Hapus slot jadwal
     */
    public function destroy(JadwalSlot $slot)
    {
        $slot->delete();
        return redirect()->back()->with('success', 'Jadwal slot berhasil dihapus.');
    }
}
