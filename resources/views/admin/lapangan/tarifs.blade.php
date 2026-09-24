@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mb-16">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.lapangan.index') }}" class="text-xs font-bold uppercase tracking-wider text-[#0d9488] hover:text-[#0f766e]">
                &larr; Kembali ke Daftar Lapangan
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f] mt-1">
                Kelola Tarif Khusus / Jam Sibuk (Dynamic Pricing)
            </h1>
            <p class="text-sm text-[#64748b]">
                Atur skema tarif dinamis untuk <strong>{{ $lapangan->nama }}</strong> (Tarif Standar: Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}/jam).
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        {{-- Form Tambah Skema Tarif --}}
        <div class="md:col-span-5 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-4">Tambah Skema Tarif Baru</h2>

            <form action="{{ route('admin.lapangan.tarifs.store', $lapangan->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Nama / Label Skema</label>
                    <input type="text" name="label" placeholder="Contoh: Peak Hour Malam, Weekend Siang" required
                           class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Hari Berlaku</label>
                    <select name="tipe_hari" class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                        <option value="all">Setiap Hari (Senin - Minggu)</option>
                        <option value="weekday">Hari Kerja Saja (Senin - Jumat)</option>
                        <option value="weekend">Akhir Pekan Saja (Sabtu - Minggu)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="18:00" required
                               class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="23:00" required
                               class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Tarif Khusus (Rp / Jam)</label>
                    <input type="number" name="harga" min="1000" step="1000" placeholder="Contoh: 180000" required
                           class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-bold rounded-xl text-sm shadow-sm transition-colors mt-2">
                    Simpan Skema Tarif
                </button>
            </form>
        </div>

        {{-- Tabel Daftar Skema Tarif Aktif --}}
        <div class="md:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-base font-bold text-[#1e3a5f]">Daftar Tarif Dinamis Aktif</h2>
                <p class="text-xs text-gray-500">Slot yang di-generate pada rentang waktu ini akan otomatis menggunakan tarif ini.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
                    <thead class="bg-gray-50 font-bold text-gray-600 uppercase">
                        <tr>
                            <th class="p-4">Label & Hari</th>
                            <th class="p-4">Rentang Jam</th>
                            <th class="p-4">Tarif</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tarifs as $trf)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">
                                    <span class="font-bold text-gray-900 block text-sm">{{ $trf->label ?? 'Tarif Khusus' }}</span>
                                    <span class="text-[11px] text-gray-500 uppercase font-semibold">
                                        {{ $trf->tipe_hari === 'all' ? 'Setiap Hari' : ($trf->tipe_hari === 'weekday' ? 'Senin - Jumat' : 'Sabtu - Minggu') }}
                                    </span>
                                </td>
                                <td class="p-4 font-mono font-bold text-teal-800">
                                    {{ substr($trf->jam_mulai, 0, 5) }} - {{ substr($trf->jam_selesai, 0, 5) }} WIB
                                </td>
                                <td class="p-4">
                                    <span class="font-black text-gray-900 text-sm">
                                        Rp {{ number_format($trf->harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.tarifs.destroy', $trf->id) }}" method="POST" onsubmit="return confirm('Hapus skema tarif ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400">
                                    Belum ada aturan tarif khusus. Seluruh slot akan menggunakan tarif standar lapangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
