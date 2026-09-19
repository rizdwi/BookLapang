@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#1e3a5f]">Kelola Pesanan</h1>
        <p class="text-[#64748b]">Daftar semua pesanan dari pelanggan.</p>
    </div>
    
    <form action="{{ route('admin.booking.index') ?? '#' }}" method="GET" class="flex gap-2 w-full sm:w-auto">
        <select name="status" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] sm:text-sm rounded-md border">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#1e3a5f] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
            Filter
        </button>
    </form>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">ID & Tgl Booking</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Pelanggan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Lapangan & Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#64748b] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#1a1a1a]">#{{ $booking->id }}</div>
                                <div class="text-sm text-[#64748b]">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-[#1a1a1a]">{{ $booking->user->name ?? 'User' }}</div>
                                <div class="text-sm text-[#64748b]">{{ $booking->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#1a1a1a]">{{ $booking->lapangan->nama ?? '-' }}</div>
                                <div class="text-sm text-[#64748b]">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }} | {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.booking.update', $booking->id) ?? '#' }}" method="POST" class="inline-flex flex-col gap-1 items-end">
                                    @csrf
                                    @method('PATCH')
                                    
                                    @if($booking->status == 'pending')
                                        <button type="submit" name="status" value="confirmed" class="text-xs text-white bg-[#0d9488] hover:bg-[#0f766e] px-2 py-1 rounded w-24 text-center">Konfirmasi</button>
                                        <button type="submit" name="status" value="cancelled" class="text-xs text-white bg-[#dc2626] hover:bg-red-700 px-2 py-1 rounded w-24 text-center">Batalkan</button>
                                    @elseif($booking->status == 'confirmed')
                                        <button type="submit" name="status" value="done" class="text-xs text-white bg-green-600 hover:bg-green-700 px-2 py-1 rounded w-24 text-center">Selesai</button>
                                        <button type="submit" name="status" value="cancelled" class="text-xs text-white bg-[#dc2626] hover:bg-red-700 px-2 py-1 rounded w-24 text-center">Batalkan</button>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada aksi</span>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @if($booking->catatan)
                        <tr>
                            <td colspan="5" class="px-6 py-2 bg-gray-50 text-sm text-[#64748b]">
                                <strong>Catatan:</strong> {{ $booking->catatan }}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-[#64748b]">
                            Belum ada data pesanan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    @if(isset($bookings) && method_exists($bookings, 'links'))
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
