@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#1e3a5f]">Kelola Fasilitas Lapangan</h1>
        <p class="text-sm text-[#64748b]">Daftar seluruh lapangan olahraga yang tersedia di sistem.</p>
    </div>
    <div>
        <a href="{{ route('admin.lapangan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors">
            + Tambah Lapangan Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Foto & Nama Lapangan</th>
                    <th class="px-6 py-3.5">Kategori</th>
                    <th class="px-6 py-3.5">Tarif Sewa</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(isset($lapangan) && count($lapangan) > 0)
                    @foreach($lapangan as $lap)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-14 rounded-lg bg-gray-100 overflow-hidden shrink-0 border border-gray-200">
                                        <img class="h-full w-full object-cover" src="{{ $lap->foto_url }}" alt="{{ $lap->nama }}" loading="lazy">
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $lap->nama }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $lap->alamat }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 uppercase tracking-wider">
                                    {{ ucfirst($lap->tipe) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-[#1e3a5f]">
                                Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}<span class="text-xs font-normal text-gray-500">/jam</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lap->aktif)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end items-center gap-2">
                                    {{-- Tombol Tarif Khusus (Peak/Weekend) --}}
                                    <a href="{{ route('admin.lapangan.tarifs.index', $lap->id) }}" 
                                       class="px-2.5 py-1 text-xs font-semibold text-amber-800 bg-amber-50 border border-amber-200 hover:bg-amber-100 rounded-lg transition-colors"
                                       title="Atur Tarif Dinamis / Jam Sibuk">
                                        Tarif Khusus
                                    </a>

                                    {{-- Tombol Kelola Jadwal --}}
                                    <a href="{{ route('admin.jadwal.index', ['lapangan_id' => $lap->id]) }}" 
                                       class="px-2.5 py-1 text-xs font-semibold text-teal-800 bg-teal-50 border border-teal-200 hover:bg-teal-100 rounded-lg transition-colors"
                                       title="Atur Slot Jam Lapangan Ini">
                                        Jadwal Slot
                                    </a>

                                    <a href="{{ route('admin.lapangan.edit', $lap->id) }}" 
                                       class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-lg transition-colors">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.lapangan.destroy', $lap->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 border border-red-200 hover:bg-red-100 rounded-lg transition-colors">
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
                            Belum ada data lapangan. Silakan klik "Tambah Lapangan Baru".
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
