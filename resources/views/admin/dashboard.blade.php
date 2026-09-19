@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Dasbor Pengelola Lapangan</h1>
        <p class="text-sm text-[#64748b]">Pantau statistik pemesanan, ketersediaan lapangan, dan omset real-time.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.lapangan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors">
            + Tambah Lapangan
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-colors">
            Kelola Jadwal
        </a>
    </div>
</div>

{{-- Kartu Metrik Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Total Lapangan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center">
        <div class="p-3 rounded-lg bg-blue-50 text-[#1e3a5f] mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Lapangan</span>
            <span class="text-2xl font-black text-[#1e3a5f]">{{ $total_lapangan ?? 0 }} Unit</span>
        </div>
    </div>

    {{-- Booking Hari Ini --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center">
        <div class="p-3 rounded-lg bg-teal-50 text-[#0d9488] mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Booking Hari Ini</span>
            <span class="text-2xl font-black text-[#1e3a5f]">{{ $booking_hari_ini ?? 0 }} Jadwal</span>
        </div>
    </div>

    {{-- Booking Bulan Ini --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center">
        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-700 mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Booking Bulan Ini</span>
            <span class="text-2xl font-black text-[#1e3a5f]">{{ $booking_bulan_ini ?? 0 }} Pesanan</span>
        </div>
    </div>

    {{-- Pendapatan Bulan Ini --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center">
        <div class="p-3 rounded-lg bg-emerald-50 text-emerald-700 mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Pendapatan Bulan Ini</span>
            <span class="text-xl font-black text-emerald-700">Rp {{ number_format($pendapatan_bulan_ini ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

{{-- Tabel Transaksi Terkini --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-[#1e3a5f]">Pemesanan Terbaru</h2>
            <p class="text-xs text-[#64748b]">10 pesanan terakhir dari pelanggan.</p>
        </div>
        <a href="{{ route('admin.booking.index') }}" class="text-xs font-bold text-[#0d9488] hover:text-[#0f766e]">
            Kelola Semua Booking &rarr;
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">ID & Waktu</th>
                    <th class="px-6 py-3.5">Pelanggan</th>
                    <th class="px-6 py-3.5">Lapangan & Jadwal</th>
                    <th class="px-6 py-3.5">Total Tarif</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(isset($recent_bookings) && count($recent_bookings) > 0)
                    @foreach($recent_bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-[#1e3a5f] block">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 block">{{ $booking->user->name ?? 'User' }}</span>
                                <span class="text-xs text-gray-500 block">{{ $booking->user->phone ?? '-' }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 block">{{ $booking->lapangan->nama ?? '-' }}</span>
                                <span class="text-xs text-teal-700 font-medium block">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }} &bull; {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] uppercase font-bold text-gray-500 block">
                                    {{ str_replace('_', ' ', $booking->metode_pembayaran ?? 'qris') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />
                            </td>

                            {{-- Tombol Aksi Cepat Admin --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <form action="{{ route('admin.booking.update-status', $booking->id) }}" method="POST" class="inline-flex gap-1.5 justify-end">
                                    @csrf
                                    @method('PATCH')
                                    @if($booking->status === 'pending')
                                        <button type="submit" name="status" value="confirmed" class="text-xs font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] px-2.5 py-1 rounded shadow-sm transition-colors">
                                            Konfirmasi
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="text-xs font-bold text-white bg-red-600 hover:bg-red-700 px-2 py-1 rounded shadow-sm transition-colors" onclick="return confirm('Batalkan pesanan ini?');">
                                            Batal
                                        </button>
                                    @elseif($booking->status === 'confirmed')
                                        <button type="submit" name="status" value="done" class="text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-2.5 py-1 rounded shadow-sm transition-colors">
                                            Selesai
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada pemesanan baru yang masuk.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
