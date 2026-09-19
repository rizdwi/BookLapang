@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-[#1e3a5f]">Dasbor Admin</h1>
        <p class="text-[#64748b]">Ringkasan sistem dan manajemen BookLapang.</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('admin.lapangan.index') ?? '#' }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-[#1e3a5f] bg-[#f8fafc] border-[#1e3a5f] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
            Kelola Lapangan
        </a>
        <a href="{{ route('admin.booking.index') ?? '#' }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#1e3a5f] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
            Kelola Booking
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-[#f8fafc] rounded-md p-3">
                <svg class="h-6 w-6 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div class="ml-4 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-[#64748b] truncate">Total Lapangan</dt>
                    <dd class="text-2xl font-bold text-[#1a1a1a]">{{ $total_lapangan ?? 0 }}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-[#f8fafc] rounded-md p-3">
                <svg class="h-6 w-6 text-[#0d9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="ml-4 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-[#64748b] truncate">Booking Hari Ini</dt>
                    <dd class="text-2xl font-bold text-[#1a1a1a]">{{ $booking_hari_ini ?? 0 }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-[#f8fafc] rounded-md p-3">
                <svg class="h-6 w-6 text-[#0d9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="ml-4 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-[#64748b] truncate">Booking Bulan Ini</dt>
                    <dd class="text-2xl font-bold text-[#1a1a1a]">{{ $booking_bulan_ini ?? 0 }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-[#f8fafc] rounded-md p-3">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-[#64748b] truncate">Pendapatan Bulan Ini</dt>
                    <dd class="text-xl font-bold text-[#1a1a1a]">Rp {{ number_format($pendapatan_bulan_ini ?? 0, 0, ',', '.') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg leading-6 font-medium text-[#1a1a1a]">
            Pemesanan Terbaru
        </h3>
        <a href="{{ route('admin.booking.index') ?? '#' }}" class="text-sm font-medium text-[#0d9488] hover:text-[#0f766e]">Lihat semua</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Pelanggan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Lapangan & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Total Harga</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($recent_bookings) && count($recent_bookings) > 0)
                    @foreach($recent_bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                #{{ $booking->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#1a1a1a]">{{ $booking->user->name ?? 'User' }}</div>
                                <div class="text-sm text-[#64748b]">{{ $booking->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#1a1a1a]">{{ $booking->lapangan->nama ?? '-' }}</div>
                                <div class="text-sm text-[#64748b]">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }} | {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</div>
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
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-[#64748b]">
                            Belum ada pemesanan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
