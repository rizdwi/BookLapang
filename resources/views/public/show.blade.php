@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-[#0d9488] hover:text-[#0f766e]">
        &larr; Kembali ke Daftar Lapangan
    </a>
</div>

{{-- Detail Lapangan Card --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 h-64 lg:h-auto relative bg-gray-100">
            @if($lapangan->foto)
                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $lapangan->foto) }}" alt="{{ $lapangan->nama }}">
            @else
                <div class="h-full w-full flex items-center justify-center text-gray-400">
                    Tidak ada foto
                </div>
            @endif
            <span class="absolute top-4 left-4 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-[#1e3a5f]/90 text-white backdrop-blur-sm">
                {{ ucfirst($lapangan->tipe) }}
            </span>
        </div>
        <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2 border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">{{ $lapangan->nama }}</h1>
                        <p class="text-sm text-[#64748b] mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $lapangan->alamat }}
                        </p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs text-[#64748b] block">Tarif Sewa</span>
                        <span class="text-2xl font-black text-[#1e3a5f]">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-[#64748b]">/ jam</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 mb-2">Deskripsi & Fasilitas</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $lapangan->deskripsi }}</p>
                </div>
            </div>

            <div class="bg-teal-50 border border-teal-100 rounded-lg p-3 text-xs text-teal-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pilih tanggal dan jam di bawah untuk mengamankan slot bermain Anda.</span>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal & Pemilihan Slot --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-bold text-[#1e3a5f]">Ketersediaan Jadwal</h2>
            <p class="text-sm text-[#64748b]">Pilih tanggal untuk melihat daftar jam yang masih kosong.</p>
        </div>

        {{-- Form Pemilihan Tanggal --}}
        <form action="{{ route('lapangan.show', $lapangan->id) }}" method="GET" class="flex items-center gap-3">
            <div>
                <label for="tanggal" class="sr-only">Pilih Tanggal</label>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ $selectedDate }}" 
                       min="{{ date('Y-m-d') }}" 
                       class="border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm font-medium">
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-[#1e3a5f] hover:bg-slate-800 shadow-sm transition-colors">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Grid Slot Jam --}}
    @if(isset($jadwal_slots) && count($jadwal_slots) > 0)
        <div class="mb-4">
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia (Bisa Dipesan)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-gray-300"></span> Terisi / Tidak Tersedia
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($jadwal_slots as $slot)
                    <div class="border rounded-lg p-4 flex flex-col justify-between transition-all {{ $slot->tersedia ? 'border-gray-200 bg-white hover:border-teal-500 hover:shadow-sm' : 'border-gray-100 bg-gray-50 opacity-75' }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-base font-bold {{ $slot->tersedia ? 'text-gray-900' : 'text-gray-400' }}">
                                {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }}
                            </span>
                            @if($slot->tersedia)
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-gray-200 text-gray-600">
                                    Terisi
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-gray-500 mb-4">
                            Tarif: <span class="font-semibold text-gray-700">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</span>
                        </div>

                        {{-- Tombol Aksi Booking --}}
                        <div>
                            @if($slot->tersedia)
                                <a href="{{ route('booking.create', ['slot_id' => $slot->id]) }}" 
                                   class="w-full inline-flex justify-center items-center py-2 px-3 border border-transparent text-xs font-bold rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488] transition-colors shadow-sm">
                                    Pilih & Booking
                                </a>
                            @else
                                <button type="button" disabled class="w-full py-2 px-3 border border-gray-200 text-xs font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed text-center">
                                    Sudah Terisi
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="py-12 text-center border border-dashed border-gray-200 rounded-lg">
            <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h4 class="text-base font-bold text-gray-900">Belum ada slot jadwal pada tanggal ini</h4>
            <p class="text-sm text-gray-500 mt-1">Silakan pilih tanggal lain yang tercantum.</p>
        </div>
    @endif
</div>
@endsection
