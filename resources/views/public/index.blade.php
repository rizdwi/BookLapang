@extends('layouts.app')

@section('full_width', true)

@section('content')
{{-- 1. HERO SECTION (Minimalist, High Contrast & Converting) --}}
<section class="relative bg-gradient-to-b from-[#1e3a5f] via-[#162e4c] to-[#0f2138] text-white pt-12 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    {{-- Background subtle glow effect --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-400 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-blue-500 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            {{-- Kolom Kiri: Headline & Value Proposition --}}
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                {{-- Badge Keunggulan --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/10 border border-teal-400/30 text-teal-300 text-xs font-bold tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    Reservasi Lapangan Olahraga Real-Time
                </div>

                {{-- Headline Utama --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight sm:leading-none text-white">
                    Main Kapan Saja, <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-300 to-teal-200">
                        Booking Lapangan
                    </span> <br class="hidden sm:inline">
                    Tanpa Ribet.
                </h1>

                {{-- Subtitle --}}
                <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Pilih lapangan favorit, cek jam kosong detik ini juga, dan bayar instan via QRIS atau Virtual Account. Tanpa chat admin bolak-balik, dijamin bebas jadwal bentrok!
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="#katalog" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 rounded-xl text-base font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-lg shadow-teal-900/30 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <span>Cari & Pesan Lapangan</span>
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="#cara-kerja" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 rounded-xl text-base font-semibold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/15 transition-all">
                        Cara Pemesanan
                    </a>
                </div>

                {{-- Mini Trust Indicators --}}
                <div class="pt-6 border-t border-white/10 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Konfirmasi Instan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Garansi Anti Double-Booking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>QRIS & Virtual Account</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Preview Card Interaktif (Visual Hook) --}}
            <div class="lg:col-span-5">
                <div class="bg-white/95 backdrop-blur text-gray-900 rounded-2xl p-6 sm:p-7 shadow-2xl border border-white/20 relative">
                    {{-- Status Badge Card --}}
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                        <div class="flex items-center gap-2.5">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Status: Real-Time Active</span>
                        </div>
                        <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full border border-teal-100">
                            Sistem Terproteksi
                        </span>
                    </div>

                    {{-- Sample Card Lapangan Populer --}}
                    <div class="space-y-4">
                        <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="text-[11px] font-bold uppercase text-teal-600 tracking-wider block">Kategori Unggulan</span>
                                    <h4 class="font-bold text-[#1e3a5f] text-base mt-0.5">Arena Futsal Premiere (Indoor)</h4>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Rawamangun, Jakarta Timur
                                    </p>
                                </div>
                                <span class="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md shrink-0">
                                    Slot Terbuka
                                </span>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-gray-400 block">Jadwal Populer</span>
                                    <span class="font-bold text-gray-800">Malam Ini • 19:00 - 20:00 WIB</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-gray-400 block">Tarif Sewa</span>
                                    <span class="font-black text-[#1e3a5f] text-sm">Rp 150.000<span class="font-normal text-[11px] text-gray-500">/jam</span></span>
                                </div>
                            </div>
                        </div>

                        {{-- Metode Pembayaran Bar --}}
                        <div class="bg-teal-50/70 border border-teal-100 rounded-xl p-3 flex items-center justify-between text-xs">
                            <span class="text-teal-900 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pembayaran Otomatis
                            </span>
                            <span class="font-bold text-teal-800">QRIS • BCA VA • Kasir</span>
                        </div>

                        {{-- Quick Link CTA Card --}}
                        <a href="#katalog" class="w-full block text-center py-3 bg-[#1e3a5f] hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition-colors uppercase tracking-wider">
                            Pilih Jadwal Lapangan Ini &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 2. METRICS / STATISTIK CEPAT --}}
<section class="bg-white border-b border-gray-200 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-[#1e3a5f]">5+</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Cabang Olahraga Pilihan</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-[#0d9488]">100%</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Jadwal Terkonfirmasi Instan</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-[#1e3a5f]">0 Menit</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Tanpa Menunggu Balasan Chat</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-emerald-600">Garansi</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Bebas Double-Booking</span>
            </div>
        </div>
    </div>
</section>

{{-- 3. VALUE PROPOSITION / KENAPA BOOKLAPANG? --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Kenapa BookLapang?</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Solusi Modern Reservasi Lapangan</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Tinggalkan cara lama yang ribet. Nikmati kepastian waktu bermain dan efisiensi waktu untuk tim olahraga Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-[#0d9488] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Jadwal Real-Time</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Lihat slot jam yang kosong secara langsung per tanggal. Tak perlu lagi tanya admin via WA dan menunggu lama.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Anti Double-Booking</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem penguncian database instan memastikan slot yang sedang Anda pesan tidak bisa diserobot penyewa lain.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">QRIS & BCA VA Cepat</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Scan dari GoPay, OVO, Dana, ShopeePay atau salin nomor Virtual Account BCA. Bebas kirim struk transfer manual.
                </p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Tiket Booking Digital</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Kode booking tersimpan rapi di dashboard akun Anda. Cukup tunjukkan ke petugas saat tiba di lokasi pertandingan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 4. CARA KERJA (3 LANGKAH MUDAH) --}}
<section id="cara-kerja" class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-y border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Mudah & Cepat</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Hanya 3 Langkah untuk Main</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Tidak ada proses berbelit-belit. Amankan lapangan olahraga impianmu dalam kurang dari 2 menit.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Step 1 --}}
            <div class="relative flex flex-col items-center text-center p-6 rounded-2xl bg-gray-50 border border-gray-100">
                <div class="w-14 h-14 rounded-2xl bg-[#1e3a5f] text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    1
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Pilih Lapangan</h3>
                <p class="text-sm text-gray-600">
                    Cari cabang olahraga yang diinginkan: Futsal, Badminton, Basket, Tenis, atau Voli dengan fasilitas lengkap.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="relative flex flex-col items-center text-center p-6 rounded-2xl bg-gray-50 border border-gray-100">
                <div class="w-14 h-14 rounded-2xl bg-[#0d9488] text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    2
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Tentukan Jadwal & Jam</h3>
                <p class="text-sm text-gray-600">
                    Pilih tanggal main dan klik slot jam yang masih berstatus hijau (Tersedia) sesuai kesepakatan timmu.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="relative flex flex-col items-center text-center p-6 rounded-2xl bg-gray-50 border border-gray-100">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    3
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Bayar & Langsung Main</h3>
                <p class="text-sm text-gray-600">
                    Selesaikan reservasi dengan QRIS atau BCA Virtual Account. Tiket terbit otomatis dan Anda siap beraksi!
                </p>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="#katalog" class="inline-flex items-center text-sm font-bold text-[#0d9488] hover:text-[#0f766e]">
                Lihat daftar lapangan yang siap dipesan &rarr;
            </a>
        </div>
    </div>
</section>

{{-- 5. KATALOG LAPANGAN (CORE CONVERSION SECTION) --}}
<section id="katalog" class="py-16 px-4 sm:px-6 lg:px-8 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Pilihan Terbaik</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Katalog Lapangan Olahraga</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Pilih kategori olahraga di bawah untuk melihat fasilitas dan ketersediaan jadwal terdekat.
            </p>
        </div>

        {{-- Filter Kategori --}}
        <div class="mb-10 flex flex-wrap justify-center gap-2">
            @php
                $categories = [
                    'semua' => 'Semua Lapangan',
                    'futsal' => 'Futsal',
                    'badminton' => 'Badminton',
                    'basket' => 'Basket',
                    'tenis' => 'Tenis',
                    'voli' => 'Bola Voli',
                ];
                $currentType = request('tipe', 'semua');
            @endphp

            @foreach($categories as $key => $label)
                <a href="{{ $key === 'semua' ? route('home') . '#katalog' : route('home', ['tipe' => $key]) . '#katalog' }}"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-150 {{ $currentType === $key ? 'bg-[#1e3a5f] text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:border-gray-400 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Grid Daftar Lapangan --}}
        @if(isset($lapangan) && count($lapangan) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($lapangan as $lap)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-lg transition-all duration-200 group">
                        
                        {{-- Foto Lapangan --}}
                        <div class="relative h-52 w-full bg-gray-100 overflow-hidden">
                            <img src="{{ $lap->foto_url }}" alt="{{ $lap->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">

                            {{-- Badge Tipe --}}
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-[#1e3a5f]/90 text-white backdrop-blur-sm shadow-sm">
                                {{ ucfirst($lap->tipe) }}
                            </span>

                            {{-- Badge Status --}}
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-500 text-white shadow-sm flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Tersedia
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

                            <p class="text-sm text-gray-600 mb-5 line-clamp-2 leading-relaxed">
                                {{ $lap->deskripsi }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] text-gray-500 uppercase tracking-wider block font-semibold">Tarif Sewa</span>
                                    <span class="text-xl font-black text-[#1e3a5f]">
                                        Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}
                                        <span class="text-xs font-normal text-[#64748b]">/jam</span>
                                    </span>
                                </div>
                                <a href="{{ route('lapangan.show', $lap->id) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488] shadow-sm transition-all transform hover:-translate-y-0.5">
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
                <h3 class="text-base font-bold text-gray-900">Tidak ada lapangan pada kategori ini</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan pilih kategori olahraga lainnya atau kembali ke semua lapangan.</p>
                <div class="mt-5">
                    <a href="{{ route('home') }}#katalog" class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#1e3a5f] rounded-xl hover:bg-opacity-90">
                        Lihat Semua Lapangan
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- 6. TESTIMONIAL / SOCIAL PROOF --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Suara Komunitas</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Dipercaya Penggiat Olahraga</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Lihat pengalaman kapten tim dan komunitas yang telah beralih ke reservasi online BookLapang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Testi 1 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-700 italic leading-relaxed">
                        "Dulu sering banget drama tim udah siap di lapangan tapi ternyata jamnya bentrok sama orang lain. Di BookLapang begitu bayar via QRIS tiket langsung keluar, sangat terpercaya!"
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-gray-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#1e3a5f] text-white font-bold flex items-center justify-center text-xs">
                        BS
                    </div>
                    <div>
                        <span class="font-bold text-gray-900 text-sm block">Budi Santoso</span>
                        <span class="text-xs text-gray-500 block">Kapten Futsal FC Jakarta</span>
                    </div>
                </div>
            </div>

            {{-- Testi 2 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-700 italic leading-relaxed">
                        "Suka banget sama tampilannya yang bersih dan enteng. Jam-jam yang kosong kelihatan jelas banget per harinya. Nggak buang-buang waktu chat WA."
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-gray-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#0d9488] text-white font-bold flex items-center justify-center text-xs">
                        KP
                    </div>
                    <div>
                        <span class="font-bold text-gray-900 text-sm block">Kevin Pratama</span>
                        <span class="text-xs text-gray-500 block">Koordinator Badminton Sudirman</span>
                    </div>
                </div>
            </div>

            {{-- Testi 3 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200/80 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-700 italic leading-relaxed">
                        "Prosesnya bener-bener sat-set! Habis tanding kantor tiap hari Jumat langsung pesan slot buat minggu depannya lewat HP. Sangat direkomendasikan."
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-gray-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-700 text-white font-bold flex items-center justify-center text-xs">
                        DP
                    </div>
                    <div>
                        <span class="font-bold text-gray-900 text-sm block">Dwi Prasetyo</span>
                        <span class="text-xs text-gray-500 block">Komunitas Basket Senayan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 7. FAQ ACCORDION (Interactive via Alpine.js) --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-[#f8fafc]" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Pertanyaan Umum</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Sering Ditanyakan</h2>
            <p class="text-sm text-gray-600 mt-2">Punya pertanyaan sebelum memesan? Berikut jawabannya.</p>
        </div>

        <div class="space-y-3">
            {{-- FAQ 1 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="w-full px-6 py-4 text-left font-bold text-[#1e3a5f] flex justify-between items-center text-sm sm:text-base hover:bg-gray-50">
                    <span>Apakah saya harus membuat akun untuk memesan lapangan?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 1" x-collapse class="px-6 pb-4 text-sm text-gray-600 border-t border-gray-100 pt-3">
                    Ya, Anda cukup mendaftar akun dalam 30 detik menggunakan nama, nomor HP, dan email. Akun ini berguna untuk menyimpan invoice, riwayat transaksi, dan bukti booking resmi.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="w-full px-6 py-4 text-left font-bold text-[#1e3a5f] flex justify-between items-center text-sm sm:text-base hover:bg-gray-50">
                    <span>Bagaimana cara melakukan pembayaran?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 2" x-collapse class="px-6 pb-4 text-sm text-gray-600 border-t border-gray-100 pt-3">
                    Kami menyediakan metode QRIS (bisa scan pakai GoPay, OVO, Dana, LinkAja, ShopeePay, dan mobile banking mana pun), Virtual Account BCA, serta opsi pembayaran tunai langsung di kasir lapangan.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="w-full px-6 py-4 text-left font-bold text-[#1e3a5f] flex justify-between items-center text-sm sm:text-base hover:bg-gray-50">
                    <span>Apakah ada kemungkinan jadwal saya bertabrakan dengan penyewa lain?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 3" x-collapse class="px-6 pb-4 text-sm text-gray-600 border-t border-gray-100 pt-3">
                    Tidak. Sistem kami menggunakan algoritma <em>pessimistic lock</em> pada level database. Begitu Anda memilih slot dan menekan tombol konfirmasi, slot tersebut otomatis dikunci dan ditutup untuk penyewa lain.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 4 ? null : 4"
                        class="w-full px-6 py-4 text-left font-bold text-[#1e3a5f] flex justify-between items-center text-sm sm:text-base hover:bg-gray-50">
                    <span>Bisakah saya membatalkan pesanan jika berhalangan hadir?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="activeAccordion === 4 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 4" x-collapse class="px-6 pb-4 text-sm text-gray-600 border-t border-gray-100 pt-3">
                    Bisa. Selama status pesanan masih menunggu pembayaran (pending), Anda dapat membatalkannya langsung melalui halaman Dasbor & Riwayat Pesanan Anda.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 8. CLOSING CTA BANNER (CONVERSION FINISHER) --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-[#1e3a5f] via-[#162e4c] to-[#0d9488] text-white">
    <div class="max-w-5xl mx-auto text-center space-y-6">
        <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-teal-300 text-xs font-bold uppercase tracking-wider">
            Slot Waktu Terbatas
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
            Siap Mengatur Jadwal Tanding Mingguan Timmu?
        </h2>
        <p class="text-slate-200 max-w-2xl mx-auto text-sm sm:text-base">
            Amankan jam main favoritmu sebelum keduluan tim lain. Dapatkan kepastian jadwal dalam genggaman tangan.
        </p>
        <div class="pt-4">
            <a href="#katalog" 
               class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-extrabold text-[#1e3a5f] bg-white hover:bg-teal-50 shadow-2xl transition-all transform hover:-translate-y-0.5">
                <span>Pesan Lapangan Sekarang</span>
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
