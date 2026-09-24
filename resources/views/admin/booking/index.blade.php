@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Kelola Data Pesanan</h1>
        <p class="text-sm text-[#64748b]">Verifikasi pemesanan lapangan, konfirmasi jadwal, dan pantau status transaksi.</p>
    </div>

    <div class="flex items-center gap-2 flex-wrap">
        {{-- Tombol Check-In Scanner Kasir --}}
        <a href="{{ route('admin.checkin.view') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
            Check-In Scanner
        </a>

        {{-- Tombol Export CSV Laporan --}}
        <a href="{{ route('admin.booking.export', request()->all()) }}" class="px-4 py-2 bg-[#1e3a5f] hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Export Excel (CSV)
        </a>
    </div>
</div>

{{-- Bar Pencarian & Filter --}}
<div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm mb-6">
    <form action="{{ route('admin.booking.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
        <div class="relative flex-grow w-full">
            <input type="text" 
                   name="q" 
                   value="{{ request('q') }}" 
                   placeholder="Cari kode booking, nama customer, atau lapangan..." 
                   class="w-full border border-gray-300 rounded-xl py-2 pl-9 pr-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <select name="status" class="w-full sm:w-auto border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
            <option value="">Semua Status Transaksi</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Selesai (Check-in)</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>

        <button type="submit" class="w-full sm:w-auto bg-[#1e3a5f] text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-slate-800 transition-colors">
            Cari
        </button>

        @if(request('status') || request('q'))
            <a href="{{ route('admin.booking.index') }}" class="text-xs text-red-600 hover:underline font-bold px-2">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-12">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Kode & Tgl Buat</th>
                    <th class="px-6 py-3.5">Data Pelanggan</th>
                    <th class="px-6 py-3.5">Lapangan & Jadwal Main</th>
                    <th class="px-6 py-3.5">Total & Pembayaran</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-black text-[#1e3a5f] block text-sm">
                                    {{ $booking->kode_booking ?? ('#BK-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT)) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</span>
                                <a href="{{ route('booking.ticket', $booking->id) }}" target="_blank" class="text-[11px] text-teal-600 hover:underline block font-semibold mt-0.5">
                                    Lihat Tiket &rarr;
                                </a>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 block">{{ $booking->user->name ?? 'User' }}</span>
                                <span class="text-xs text-gray-500 block">{{ $booking->user->no_hp ?? '-' }} &bull; {{ $booking->user->email ?? '-' }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900 block">{{ $booking->lapangan->nama ?? '-' }}</span>
                                <span class="text-xs text-teal-700 font-semibold block">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }} &bull; {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                </span>
                                @if($booking->bookingSlots->count() > 1)
                                    <span class="text-[10px] bg-teal-50 text-teal-700 px-1.5 py-0.5 rounded font-bold">
                                        {{ $booking->bookingSlots->count() }} Slot Jam Terpilih
                                    </span>
                                @endif
                                @if($booking->catatan)
                                    <p class="text-xs text-gray-500 mt-1 max-w-xs truncate" title="{{ $booking->catatan }}">
                                        <em>Catatan: "{{ $booking->catatan }}"</em>
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-black text-[#1e3a5f] text-base block">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-bold uppercase bg-gray-100 px-2 py-0.5 rounded text-gray-700">
                                    {{ str_replace('_', ' ', $booking->metode_pembayaran ?? 'qris') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <form action="{{ route('admin.booking.update-status', $booking->id) }}" method="POST" class="inline-flex gap-1 justify-end">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @if($booking->status === 'pending')
                                        <button type="submit" name="status" value="confirmed" class="px-2.5 py-1 text-xs font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] rounded-lg shadow-sm">
                                            Konfirmasi
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="px-2.5 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm" onclick="return confirm('Tolak/batalkan pesanan ini?');">
                                            Tolak
                                        </button>
                                    @elseif($booking->status === 'confirmed')
                                        <button type="submit" name="status" value="done" class="px-2.5 py-1 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">
                                            Check-In Selesai
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="px-2.5 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm" onclick="return confirm('Batalkan pesanan ini?');">
                                            Batalkan
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada aksi</span>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Tidak ditemukan data pesanan untuk filter status ini.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($bookings) && method_exists($bookings, 'links'))
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
