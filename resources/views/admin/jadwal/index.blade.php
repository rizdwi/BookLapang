@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Kelola Jadwal & Slot Waktu</h1>
        <p class="text-sm text-[#64748b]">Generate slot waktu baru dan atur ketersediaan jam sewa lapangan.</p>
    </div>
</div>

{{-- Card Generator Slot Massal --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <h2 class="text-base font-bold text-[#1e3a5f] uppercase tracking-wider mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-[#0d9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Generate Jadwal Slot Massal
    </h2>

    <form action="{{ route('admin.jadwal.generate-bulk') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
            {{-- Pilih Lapangan --}}
            <div class="lg:col-span-2">
                <label for="lapangan_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Lapangan
                </label>
                <select id="lapangan_id" name="lapangan_id" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                    @foreach($lapanganList as $lap)
                        <option value="{{ $lap->id }}" {{ $selectedLapanganId == $lap->id ? 'selected' : '' }}>
                            {{ $lap->nama }} ({{ ucfirst($lap->tipe) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Rentang Tanggal --}}
            <div>
                <label for="tanggal_mulai" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Mulai Tanggal
                </label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm">
            </div>

            <div>
                <label for="tanggal_selesai" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Sampai Tanggal
                </label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+6 days')) }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm">
            </div>

            {{-- Jam Operasional --}}
            <div>
                <label for="jam_mulai" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                    Jam Operasional
                </label>
                <div class="flex items-center gap-1">
                    <input type="text" name="jam_mulai" value="08:00" placeholder="08:00" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-center">
                    <span class="text-xs text-gray-400">-</span>
                    <input type="text" name="jam_selesai" value="22:00" placeholder="22:00" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-center">
                </div>
            </div>

            {{-- Tombol Generate --}}
            <div>
                <button type="submit" class="w-full py-2.5 px-4 rounded-lg font-bold text-sm text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors">
                    Generate Slot
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Filter & Daftar Slot --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-bold text-[#1e3a5f]">Daftar Slot Jadwal</h3>
            <p class="text-xs text-[#64748b]">Kelola ketersediaan atau tutup slot tertentu secara manual.</p>
        </div>

        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <select name="lapangan_id" class="border border-gray-300 rounded-lg py-1.5 px-3 text-xs font-medium">
                @foreach($lapanganList as $lap)
                    <option value="{{ $lap->id }}" {{ $selectedLapanganId == $lap->id ? 'selected' : '' }}>
                        {{ $lap->nama }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="tanggal" value="{{ $selectedDate }}" class="border border-gray-300 rounded-lg py-1.5 px-2.5 text-xs font-medium">

            <button type="submit" class="bg-[#1e3a5f] text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-800">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Lapangan</th>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5">Jam Slot</th>
                    <th class="px-6 py-3.5">Status Ketersediaan</th>
                    <th class="px-6 py-3.5 text-right">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(isset($jadwal) && count($jadwal) > 0)
                    @foreach($jadwal as $slot)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $slot->lapangan->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($slot->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-[#1e3a5f]">
                                {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }} WIB
                            </td>
                            <td class="px-6 py-4">
                                @if($slot->tersedia)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Tersedia (Bisa Dipesan)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                        Ditutup / Terisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.jadwal.toggle', $slot->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($slot->tersedia)
                                            <button type="submit" class="px-2.5 py-1 rounded text-xs font-semibold text-amber-800 bg-amber-50 border border-amber-200 hover:bg-amber-100">
                                                Tutup Slot
                                            </button>
                                        @else
                                            <button type="submit" class="px-2.5 py-1 rounded text-xs font-semibold text-teal-800 bg-teal-50 border border-teal-200 hover:bg-teal-100">
                                                Buka Slot
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.jadwal.destroy', $slot->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus slot jam ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 rounded text-xs font-semibold text-red-700 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada slot jadwal untuk kriteria pencarian ini. Silakan generate jadwal massal di form atas.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($jadwal) && method_exists($jadwal, 'links'))
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $jadwal->links() }}
        </div>
    @endif
</div>
@endsection
