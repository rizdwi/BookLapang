@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Visual Timetable & Kalender Kasir</h1>
        <p class="text-sm text-[#64748b]">Matriks ketersediaan slot lapangan per jam untuk melayani customer walk-in dan memantau status lapangan secara visual.</p>
    </div>

    {{-- Filter Tanggal & Tipe --}}
    <form action="{{ route('admin.timetable') }}" method="GET" class="flex flex-wrap items-center gap-2">
        <input type="date" 
               name="tanggal" 
               value="{{ $selectedDate }}" 
               class="border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] font-medium">
        
        <select name="tipe" class="border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
            <option value="">Semua Cabang</option>
            <option value="futsal" {{ request('tipe') === 'futsal' ? 'selected' : '' }}>Futsal</option>
            <option value="badminton" {{ request('tipe') === 'badminton' ? 'selected' : '' }}>Badminton</option>
            <option value="basket" {{ request('tipe') === 'basket' ? 'selected' : '' }}>Basket</option>
            <option value="tenis" {{ request('tipe') === 'tenis' ? 'selected' : '' }}>Tenis</option>
            <option value="voli" {{ request('tipe') === 'voli' ? 'selected' : '' }}>Voli</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-[#1e3a5f] hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm transition-colors">
            Tampilkan
        </button>
    </form>
</div>

{{-- Legend Status --}}
<div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm mb-6 flex flex-wrap items-center gap-4 sm:gap-6 text-xs font-semibold">
    <div class="flex items-center gap-2">
        <span class="w-3.5 h-3.5 rounded bg-emerald-500"></span>
        <span class="text-gray-700">Tersedia (Kosong)</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="w-3.5 h-3.5 rounded bg-amber-400"></span>
        <span class="text-gray-700">Pending (Menunggu Bayar)</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="w-3.5 h-3.5 rounded bg-teal-600"></span>
        <span class="text-gray-700">Confirmed (Terkonfirmasi)</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="w-3.5 h-3.5 rounded bg-blue-600"></span>
        <span class="text-gray-700">Done (Sedang/Selesai Main)</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="w-3.5 h-3.5 rounded bg-gray-200"></span>
        <span class="text-gray-500">Belum Ada Slot / Tutup</span>
    </div>
</div>

{{-- Matriks Timetable Grid --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-12">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-base font-bold text-[#1e3a5f]">
            Jadwal: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
        </h2>
        <span class="text-xs text-gray-500">Total {{ $lapanganList->count() }} Lapangan Terdaftar</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse text-left text-xs">
            <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200">
                <tr>
                    <th class="p-3.5 sticky left-0 bg-gray-50 z-20 min-w-[180px] border-r border-gray-200">Lapangan</th>
                    @foreach($operationalHours as $jam)
                        <th class="p-3 text-center min-w-[90px] border-r border-gray-200 font-mono">
                            {{ substr($jam, 0, 5) }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($lapanganList as $lap)
                    <tr class="hover:bg-gray-50/50">
                        {{-- Kolom Sticky Nama Lapangan --}}
                        <td class="p-3.5 sticky left-0 bg-white hover:bg-gray-50 z-10 border-r border-gray-200 font-bold text-[#1e3a5f] shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                            <span class="block text-sm font-black">{{ $lap->nama }}</span>
                            <span class="text-[11px] font-semibold text-gray-500 uppercase">{{ $lap->tipe }}</span>
                        </td>

                        {{-- Kolom Tiap Jam --}}
                        @foreach($operationalHours as $jam)
                            @php
                                $jamMulaiStr = $jam . ':00';
                                // Cari slot jadwal di lapangan ini pada jam terkait
                                $slot = $lap->jadwalSlots->first(function ($s) use ($jam) {
                                    return substr($s->jam_mulai, 0, 2) === substr($jam, 0, 2);
                                });
                                $booking = $slot ? ($slotBookingMap[$slot->id] ?? null) : null;
                            @endphp

                            <td class="p-1.5 text-center border-r border-gray-200 align-middle">
                                @if(!$slot)
                                    <div class="h-14 rounded-lg bg-gray-50 border border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                        -
                                    </div>
                                @elseif($booking)
                                    @if($booking->status === 'pending')
                                        <div class="h-14 rounded-lg bg-amber-100 border border-amber-300 p-1 flex flex-col justify-center text-[10px] text-amber-900 leading-tight shadow-sm" title="Pending: {{ $booking->user->name }}">
                                            <span class="font-bold truncate">{{ $booking->user->name }}</span>
                                            <span class="text-[9px] font-mono font-semibold">{{ $booking->kode_booking }}</span>
                                            <span class="text-[9px] font-bold text-amber-700 uppercase">Menunggu</span>
                                        </div>
                                    @elseif($booking->status === 'confirmed')
                                        <div class="h-14 rounded-lg bg-teal-100 border border-teal-400 p-1 flex flex-col justify-center text-[10px] text-teal-950 leading-tight shadow-sm" title="Confirmed: {{ $booking->user->name }}">
                                            <span class="font-bold truncate">{{ $booking->user->name }}</span>
                                            <span class="text-[9px] font-mono font-semibold">{{ $booking->kode_booking }}</span>
                                            <span class="text-[9px] font-bold text-teal-700 uppercase">Siap Main</span>
                                        </div>
                                    @elseif($booking->status === 'done')
                                        <div class="h-14 rounded-lg bg-blue-100 border border-blue-300 p-1 flex flex-col justify-center text-[10px] text-blue-900 leading-tight shadow-sm" title="Selesai: {{ $booking->user->name }}">
                                            <span class="font-bold truncate">{{ $booking->user->name }}</span>
                                            <span class="text-[9px] font-bold text-blue-700 uppercase">Selesai</span>
                                        </div>
                                    @else
                                        <div class="h-14 rounded-lg bg-gray-100 border border-gray-200 p-1 flex items-center justify-center text-gray-500 text-[10px]">
                                            Batal
                                        </div>
                                    @endif
                                @elseif($slot->tersedia)
                                    <div class="h-14 rounded-lg bg-emerald-50 border border-emerald-300 hover:bg-emerald-100 transition-colors p-1 flex flex-col justify-center text-emerald-800 shadow-sm cursor-default">
                                        <span class="font-black text-[11px]">KOSONG</span>
                                        <span class="text-[9px] font-semibold">Rp {{ number_format($slot->harga_efektif, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="h-14 rounded-lg bg-gray-100 border border-gray-200 p-1 flex items-center justify-center text-gray-400 text-[10px] font-semibold">
                                        TUTUP
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($operationalHours) + 1 }}" class="p-8 text-center text-gray-500">
                            Tidak ada lapangan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
