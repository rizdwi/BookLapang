@extends('layouts.app')

@section('content')
{{-- Breadcrumb & Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-emerald-600 hover:text-emerald-700 transition-colors mb-2">
            &larr; Kembali ke Beranda
        </a>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
            Katalog & Jadwal Lapangan
        </h1>
        <p class="text-sm text-slate-600 mt-1 max-w-2xl">
            Cari venue berdasarkan cabang olahraga, tanggal main, atau jam kosong. Klik <strong class="text-slate-900">Cek Jadwal</strong> untuk reservasi langsung.
        </p>
    </div>
</div>

{{-- Bar Pencarian & Filter Ketersediaan Jam/Tanggal --}}
<div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs mb-8">
    <form action="{{ route('lapangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
        @if(request('tipe') && request('tipe') !== 'semua')
            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
        @endif
        @if(request('lokasi') && request('lokasi') !== 'semua')
            <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
        @endif

        {{-- Keyword Nama / Lokasi --}}
        <div class="lg:col-span-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Cari Nama / Lokasi</label>
            <div class="relative">
                <input type="text" 
                       name="q" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Contoh: Arena Futsal, Rawamangun..." 
                       class="w-full border border-slate-300 rounded-xl py-2 pl-9 pr-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-xs bg-slate-50/50">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        {{-- Tanggal Main --}}
        <div class="lg:col-span-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Main</label>
            <input type="date" 
                   name="tanggal" 
                   value="{{ $filterTanggal ?? '' }}" 
                   min="{{ date('Y-m-d') }}"
                   class="w-full border border-slate-300 rounded-xl py-2 px-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-xs bg-slate-50/50">
        </div>

        {{-- Jam Main --}}
        <div class="lg:col-span-2">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jam Kosong</label>
            <input type="time" 
                   name="jam" 
                   value="{{ $filterJam ?? '' }}" 
                   step="3600"
                   class="w-full border border-slate-300 rounded-xl py-2 px-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-xs bg-slate-50/50">
        </div>

        {{-- Tombol Filter --}}
        <div class="lg:col-span-2 flex items-center gap-2">
            <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-xs transition-colors text-center">
                Filter
            </button>
            @if(!empty($search) || !empty($filterTanggal) || !empty($filterJam) || request('tipe'))
                <a href="{{ route('lapangan.index') }}" title="Reset Filter" class="p-2.5 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Filter Kategori Cabang Olahraga dengan SVG Icons & Sport Palette Diversion --}}
<div class="mb-4 flex flex-wrap items-center gap-2">
    @php
        $categories = [
            'semua' => ['label' => 'Semua Lapangan', 'color' => 'slate'],
            'futsal' => ['label' => 'Futsal', 'color' => 'emerald'],
            'badminton' => ['label' => 'Badminton', 'color' => 'indigo'],
            'basket' => ['label' => 'Basket', 'color' => 'amber'],
            'tenis' => ['label' => 'Tenis', 'color' => 'lime'],
            'voli' => ['label' => 'Bola Voli', 'color' => 'sky'],
        ];
        $currentType = request('tipe', 'semua');
        $currentLokasi = request('lokasi', 'semua');
    @endphp

    @foreach($categories as $key => $catData)
        @php
            $urlParams = [];
            if ($key !== 'semua') {
                $urlParams['tipe'] = $key;
            }
            if ($currentLokasi !== 'semua') {
                $urlParams['lokasi'] = $currentLokasi;
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
            $isActive = ($currentType === $key);
        @endphp
        <a href="{{ route('lapangan.index', $urlParams) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 border {{ $isActive ? 'bg-slate-900 text-white border-slate-900 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
            @if($key === 'futsal')
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            @elseif($key === 'badminton')
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
            @elseif($key === 'basket')
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            @elseif($key === 'tenis')
                <span class="w-2 h-2 rounded-full bg-lime-500"></span>
            @elseif($key === 'voli')
                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
            @endif
            {{ $catData['label'] }}
        </a>
    @endforeach
</div>

{{-- Filter Wilayah / Lokasi --}}
<div class="mb-8 flex flex-wrap items-center gap-2">
    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-1 flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Lokasi:
    </span>
    @php
        $regions = [
            'semua' => 'Semua Lokasi',
            'Jakarta Selatan' => 'Jakarta Selatan',
            'Jakarta Barat' => 'Jakarta Barat',
            'Jakarta Pusat' => 'Jakarta Pusat',
            'Jakarta Timur' => 'Jakarta Timur',
            'Jakarta Utara' => 'Jakarta Utara',
        ];
    @endphp

    @foreach($regions as $regKey => $regLabel)
        @php
            $regUrlParams = [];
            if ($currentType !== 'semua') {
                $regUrlParams['tipe'] = $currentType;
            }
            if ($regKey !== 'semua') {
                $regUrlParams['lokasi'] = $regKey;
            }
            if (!empty($search)) {
                $regUrlParams['q'] = $search;
            }
            if (!empty($filterTanggal)) {
                $regUrlParams['tanggal'] = $filterTanggal;
            }
            if (!empty($filterJam)) {
                $regUrlParams['jam'] = $filterJam;
            }
            $isRegActive = ($currentLokasi === $regKey);
        @endphp
        @if($isRegActive)
            <a href="{{ route('lapangan.index', $regUrlParams) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 bg-emerald-600 text-white shadow-xs">
                {{ $regLabel }}
            </a>
        @else
            <a href="{{ route('lapangan.index', $regUrlParams) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 bg-slate-100 text-slate-700 hover:bg-slate-200">
                {{ $regLabel }}
            </a>
        @endif
    @endforeach
</div>

{{-- Grid Daftar Lapangan (Bolder Athletic Cards) --}}
<div class="mb-14">
    @if(isset($lapangan) && count($lapangan) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($lapangan as $lap)
                @php
                    $sportColor = match(strtolower($lap->tipe)) {
                        'futsal' => 'emerald',
                        'badminton' => 'indigo',
                        'basket' => 'amber',
                        'tenis' => 'lime',
                        'voli' => 'sky',
                        default => 'slate',
                    };
                @endphp
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden flex flex-col hover:border-slate-400 hover:shadow-lg transition-all duration-200 group">
                    
                    {{-- Foto Lapangan --}}
                    <div class="relative h-52 w-full bg-slate-900 overflow-hidden">
                        <img src="{{ $lap->foto_url }}" alt="{{ $lap->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">

                        {{-- Badges Header Foto --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider bg-slate-950/90 text-white backdrop-blur-xs shadow-xs border border-white/10">
                                {{ ucfirst($lap->tipe) }}
                            </span>
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/95 text-slate-800 backdrop-blur-xs shadow-xs flex items-center gap-1">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $lap->wilayah }}
                            </span>
                        </div>

                        {{-- Badge Live Status --}}
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-500 text-emerald-950 shadow-xs flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-950 animate-pulse"></span>
                            Bisa Dipesan
                        </span>
                    </div>

                    {{-- Konten Lapangan --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-3">
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                                {{ $lap->nama }}
                            </h3>
                            <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-1.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate">{{ $lap->alamat ?? 'Lokasi Terdaftar' }}</span>
                            </p>
                        </div>

                        <p class="text-sm text-slate-600 mb-5 line-clamp-3 leading-relaxed">
                            {{ $lap->deskripsi }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-slate-500 uppercase tracking-wider block font-semibold">Tarif Mulai</span>
                                <span class="text-xl font-black text-slate-900 font-mono tabular-nums">
                                    Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-slate-500">/jam</span>
                                </span>
                            </div>
                            <a href="{{ route('lapangan.show', ['id' => $lap->id, 'tanggal' => $filterTanggal ?? date('Y-m-d')]) }}" 
                               class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-xs transition-all transform hover:-translate-y-0.5">
                                Cek Jadwal &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center max-w-lg mx-auto">
            <svg class="mx-auto h-12 w-12 text-slate-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-base font-bold text-slate-900">Tidak ada lapangan yang sesuai</h3>
            <p class="mt-1 text-sm text-slate-500">Coba ubah tanggal, jam kosong, atau kata kunci pencarian Anda.</p>
            <div class="mt-5">
                <a href="{{ route('lapangan.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-slate-900 rounded-xl hover:bg-slate-800">
                    Tampilkan Semua Lapangan
                </a>
            </div>
        </div>
    @endif
</div>
@endsection