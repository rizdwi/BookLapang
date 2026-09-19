@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#1e3a5f]">Dasbor Pelanggan</h1>
    <p class="text-[#64748b]">Selamat datang, {{ auth()->user()->name }}!</p>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-[#1a1a1a]">
            Riwayat Pemesanan Anda
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Tanggal & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Lapangan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Total Harga</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#1a1a1a]">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</div>
                                <div class="text-sm text-[#64748b]">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#1a1a1a]">{{ $booking->lapangan->nama ?? 'Lapangan' }}</div>
                                <div class="text-sm text-[#64748b]">{{ isset($booking->lapangan) ? ucfirst($booking->lapangan->tipe) : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-[#64748b]">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p>Anda belum memiliki riwayat pemesanan.</p>
                            <a href="{{ route('home') }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                                Cari Lapangan
                            </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
