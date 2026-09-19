@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-[#1e3a5f] mb-6">Riwayat Booking Saya</h1>

    <x-flash-message />

    @if($bookings->isEmpty())
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <p class="text-[#64748b] text-lg mb-4">Belum ada booking.</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#0d9488] text-white px-6 py-2 rounded-md hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-[#0d9488] focus:ring-offset-2">
                Lihat Lapangan
            </a>
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-[#64748b] uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-semibold text-[#64748b] uppercase tracking-wider">Lapangan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-[#64748b] uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3 text-xs font-semibold text-[#64748b] uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-xs font-semibold text-[#64748b] uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $booking->tanggal_booking->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm font-medium">{{ $booking->lapangan->nama }}</td>
                            <td class="px-6 py-4 text-sm">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</td>
                            <td class="px-6 py-4 text-sm">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$booking->status" />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
