@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Kelola Data Pesanan</h1>
        <p class="text-sm text-[#64748b]">Verifikasi pemesanan lapangan, konfirmasi jadwal, dan pantau status transaksi.</p>
    </div>

    {{-- Filter Status --}}
    <form action="{{ route('admin.booking.index') }}" method="GET" class="flex items-center gap-2">
        <select name="status" class="border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
            <option value="">Semua Status Transaksi</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Selesai Digunakan</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="bg-[#1e3a5f] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-800 transition-colors">
            Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">ID & Tanggal Buat</th>
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
                                <span class="font-bold text-[#1e3a5f] block">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y H:i') }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 block">{{ $booking->user->name ?? 'User' }}</span>
                                <span class="text-xs text-gray-500 block">{{ $booking->user->phone ?? '-' }} &bull; {{ $booking->user->email ?? '-' }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900 block">{{ $booking->lapangan->nama ?? '-' }}</span>
                                <span class="text-xs text-teal-700 font-semibold block">
                                    {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }} &bull; {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                </span>
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
                                        <button type="submit" name="status" value="confirmed" class="px-2.5 py-1 text-xs font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] rounded shadow-sm">
                                            Konfirmasi
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="px-2.5 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded shadow-sm" onclick="return confirm('Tolak/batalkan pesanan ini?');">
                                            Tolak
                                        </button>
                                    @elseif($booking->status === 'confirmed')
                                        <button type="submit" name="status" value="done" class="px-2.5 py-1 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded shadow-sm">
                                            Selesai
                                        </button>
                                        <button type="submit" name="status" value="cancelled" class="px-2.5 py-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded shadow-sm" onclick="return confirm('Batalkan pesanan ini?');">
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
