@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelola Fasilitas Lapangan</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar seluruh arena & lapangan olahraga yang aktif di sistem BookLapang.</p>
    </div>
    <div>
        <a href="{{ route('admin.lapangan.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Lapangan Baru</span>
        </a>
    </div>
</div>

<x-flash-message />

<div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden mb-12">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Foto & Nama Lapangan</th>
                    <th class="px-6 py-4">Kategori Cabor</th>
                    <th class="px-6 py-4">Tarif Reguler</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @if(isset($lapangan) && count($lapangan) > 0)
                    @foreach($lapangan as $lap)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="h-12 w-14 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                        <img class="h-full w-full object-cover" src="{{ $lap->foto_url }}" alt="{{ $lap->nama }}" loading="lazy">
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $lap->nama }}</div>
                                        <div class="text-xs text-slate-500 truncate max-w-xs">{{ $lap->alamat }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 uppercase tracking-wider border border-slate-200">
                                    {{ ucfirst($lap->tipe) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-slate-900 tabular-nums">
                                Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}<span class="text-xs font-normal text-slate-400">/jam</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lap->aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Nonaktif</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end items-center gap-1.5">
                                    {{-- Tombol Tarif Khusus (Peak/Weekend) --}}
                                    <a href="{{ route('admin.lapangan.tarifs.index', $lap->id) }}" 
                                       class="px-2.5 py-1.5 text-xs font-bold text-amber-900 bg-amber-50 border border-amber-200 hover:bg-amber-100 rounded-lg transition-colors"
                                       title="Atur Tarif Dinamis / Jam Sibuk">
                                        Tarif Khusus
                                    </a>

                                    {{-- Tombol Kelola Jadwal --}}
                                    <a href="{{ route('admin.jadwal.index', ['lapangan_id' => $lap->id]) }}" 
                                       class="px-2.5 py-1.5 text-xs font-bold text-emerald-900 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 rounded-lg transition-colors"
                                       title="Atur Slot Jam Lapangan Ini">
                                        Jadwal Slot
                                    </a>

                                    <a href="{{ route('admin.lapangan.edit', $lap->id) }}" 
                                       class="px-2.5 py-1.5 text-xs font-bold text-slate-800 bg-slate-100 border border-slate-200 hover:bg-slate-200 rounded-lg transition-colors">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.lapangan.destroy', $lap->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 text-xs font-bold text-rose-800 bg-rose-50 border border-rose-200 hover:bg-rose-100 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Belum ada data lapangan. Silakan klik "Tambah Lapangan Baru".
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection