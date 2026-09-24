@extends('layouts.app')

@section('content')
{{-- Breadcrumb & Navigasi Balik --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#0d9488] hover:text-[#0f766e] transition-colors mb-2">
            &larr; Kembali ke Beranda
        </a>
        <h1 class="text-3xl sm:text-4xl font-black text-[#1e3a5f] tracking-tight">
            Pilih Lapangan Olahraga
        </h1>
        <p class="text-sm text-[#64748b] mt-1 max-w-2xl">
            Cari venue berdasarkan cabang olahraga, tanggal main, atau jam kosong. Klik <strong class="text-gray-800">Cek Jadwal</strong> untuk reservasi langsung.
        </p>
    </div>
</div>

{{-- Bar Pencarian & Filter Ketersediaan Jam/Tanggal --}}
<div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm mb-8">
    <form action="{{ route('lapangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
        @if(request('tipe') && request('tipe') !== 'semua')
            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
        @endif

        {{-- Keyword Nama / Lokasi --}}
        <div class="lg:col-span-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Cari Nama / Lokasi</label>
            <div class="relative">
                <input type="text" 
                       name="q" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Contoh: Arena Futsal, Rawamangun..." 
                       class="w-full border border-gray-300 rounded-xl py-2 pl-9 pr-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm bg-gray-50/50">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        {{-- Tanggal Main --}}
        <div class="lg:col-span-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Tanggal Main</label>
            <input type="date" 
                   name="tanggal" 
                   value="{{ $filterTanggal ?? '' }}" 
                   min="{{ date('Y-m-d') }}"
                   class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm bg-gray-50/50">
        </div>

        {{-- Jam Main --}}
        <div class="lg:col-span-2">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">Jam Kosong</label>
            <input type="time" 
                   name="jam" 
                   value="{{ $filterJam ?? '' }}" 
                   step="3600"
                   class="w-full border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm bg-gray-50/50">
        </div>

        {{-- Tombol Filter --}}
        <div class="lg:col-span-2 flex items-center gap-2">
            <button type="submit" class="w-full py-2.5 bg-[#1e3a5f] hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm transition-colors text-center">
                Filter
            </button>
            @if(!empty($search) || !empty($filterTanggal) || !empty($filterJam) || request('tipe'))
                <a href="{{ route('lapangan.index') }}" title="Reset" class="p-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Filter Kategori Cabang Olahraga --}}
<div class="mb-8 flex flex-wrap items-center gap-2">
    @php
        $categories = [
            'semua' => 'Semua Lapangan',
            'futsal' => '⚽ Futsal',
            'badminton' => '🏸 Badminton',
            'basket' => '🏀 Basket',
            'tenis' => '🎾 Tenis',
            'voli' => '🏐 Bola Voli',
        ];
        $currentType = request('tipe', 'semua');
    @endphp

    @foreach($categories as $key => $label)
        @php
            $urlParams = [];
            if ($key !== 'semua') {
                $urlParams['tipe'] = $key;
            }
            if (!empty($search)) {
                $urlParams['q'] = $search;
            }
            if (!empty($filterTanggal)) {
                $urlParams['tanggal'] = $filterTanggal;
            }
            if (!empty($filterJam)) {
                $urlParams['jam'] = $filterJam;
            }
        @endphp
        <a href="{{ route('lapangan.index', $urlParams) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-150 {{ $currentType === $key ? 'bg-[#1e3a5f] text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:border-gray-400 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Grid Daftar Lapangan --}}
<div class="mb-14">
    @if(isset($lapangan) && count($lapangan) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($lapangan as $lap)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-lg transition-all duration-200 group">
                    
                    {{-- Foto Lapangan --}}
                    <div class="relative h-52 w-full bg-gray-100 overflow-hidden">
                        <img src="{{ $lap->foto_url }}" alt="{{ $lap->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">

                        {{-- Badge Tipe --}}
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-[#1e3a5f]/90 text-white backdrop-blur-sm shadow-sm">
                            {{ ucfirst($lap->tipe) }}
                        </span>

                        {{-- Badge Live Status --}}
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-500 text-white shadow-sm flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            Bisa Dipesan
                        </span>
                    </div>

                    {{-- Konten Lapangan --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-3">
                            <h3 class="text-xl font-black text-[#1e3a5f] group-hover:text-teal-600 transition-colors">
                                {{ $lap->nama }}
                            </h3>
                            <p class="text-xs text-[#64748b] flex items-center gap-1.5 mt-1.5">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate">{{ $lap->alamat ?? 'Lokasi Terdaftar' }}</span>
                            </p>
                        </div>

                        <p class="text-sm text-gray-600 mb-5 line-clamp-3 leading-relaxed">
                            {{ $lap->deskripsi }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-gray-500 uppercase tracking-wider block font-semibold">Tarif Mulai</span>
                                <span class="text-xl font-black text-[#1e3a5f]">
                                    Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-[#64748b]">/jam</span>
                                </span>
                            </div>
                            <a href="{{ route('lapangan.show', ['id' => $lap->id, 'tanggal' => $filterTanggal ?? date('Y-m-d')]) }}" 
                               class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488] shadow-sm transition-all transform hover:-translate-y-0.5">
                                Cek Jadwal &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center max-w-lg mx-auto">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-base font-bold text-gray-900">Tidak ada lapangan yang sesuai</h3>
            <p class="mt-1 text-sm text-gray-500">Coba ubah tanggal, jam kosong, atau kata kunci pencarian Anda.</p>
            <div class="mt-5">
                <a href="{{ route('lapangan.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#1e3a5f] rounded-xl hover:bg-opacity-90">
                    Tampilkan Semua Lapangan
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
