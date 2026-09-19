@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-8">
    <h1 class="text-2xl font-bold text-[#1e3a5f] mb-6">Konfirmasi Pesanan</h1>
    
    <div class="bg-[#f8fafc] border border-gray-200 rounded-md p-4 mb-6">
        <h3 class="text-lg font-medium text-[#1a1a1a] mb-4">Detail Lapangan</h3>
        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-[#64748b]">Lapangan</dt>
                <dd class="mt-1 text-sm text-[#1a1a1a]">{{ $lapangan->nama ?? 'Nama Lapangan' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-[#64748b]">Tipe</dt>
                <dd class="mt-1 text-sm text-[#1a1a1a]">{{ isset($lapangan) ? ucfirst($lapangan->tipe) : '-' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-[#64748b]">Tanggal</dt>
                <dd class="mt-1 text-sm text-[#1a1a1a]">{{ isset($slot) ? \Carbon\Carbon::parse($slot->tanggal)->format('d/m/Y') : '-' }}</dd>
            </div>
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-[#64748b]">Waktu</dt>
                <dd class="mt-1 text-sm text-[#1a1a1a]">{{ isset($slot) ? substr($slot->jam_mulai, 0, 5) . ' - ' . substr($slot->jam_selesai, 0, 5) : '-' }}</dd>
            </div>
        </dl>
    </div>

    <form action="{{ route('booking.store') ?? '#' }}" method="POST">
        @csrf
        <input type="hidden" name="jadwal_slot_id" value="{{ $slot->id ?? '' }}">
        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id ?? '' }}">
        
        <div class="mb-6">
            <label for="catatan" class="block text-sm font-medium text-[#1a1a1a]">Catatan Tambahan (Opsional)</label>
            <div class="mt-1">
                <textarea id="catatan" name="catatan" rows="3" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] mt-1 block w-full sm:text-sm border border-gray-300 rounded-md px-3 py-2" placeholder="Contoh: Pinjam bola, dll."></textarea>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6 flex items-center justify-between">
            <div>
                <p class="text-sm text-[#64748b]">Total Harga</p>
                <p class="text-2xl font-bold text-[#1a1a1a]">Rp {{ isset($lapangan) ? number_format($lapangan->harga_per_jam, 0, ',', '.') : '0' }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ isset($lapangan) ? route('lapangan.show', $lapangan->id) : '#' }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-[#1a1a1a] bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                    Konfirmasi Pesanan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
