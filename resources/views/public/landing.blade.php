@extends('layouts.app')

@section('full_width', true)

@section('content')
{{-- 1. HERO SECTION (High-Contrast, Athletic & Confident) --}}
<section class="relative bg-slate-950 text-white pt-14 pb-20 px-4 sm:px-6 lg:px-8 border-b border-slate-800/80 overflow-hidden">
    {{-- High-craft subtle stadium pitch markings & grid backdrop --}}
    <div class="absolute inset-0 pointer-events-none opacity-[0.06] bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-40 right-1/4 w-96 h-96 bg-emerald-600/10 rounded-full filter blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            {{-- Kolom Kiri: Value Proposition & High Impact Action --}}
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                {{-- Live Badge Status Platform --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-950/90 border border-emerald-500/30 text-emerald-300 text-xs font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>SISTEM RESERVASI REAL-TIME • 100% BEBAS BENTROK</span>
                </div>

                {{-- Bolder Headline (No gradient text tell) --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.08] text-white">
                    Main Kapan Saja, <br class="hidden sm:inline">
                    <span class="text-emerald-400">Booking Lapangan</span> <br class="hidden sm:inline">
                    Pasti Dapat Jadwal.
                </h1>

                {{-- Deskripsi Nilai Tambah --}}
                <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Cek jadwal kosong detik ini juga, amankan slot main timmu dengan kunci otomatis, dan bayar instan via QRIS atau Virtual Account. Tanpa menunggu chat WhatsApp manual.
                </p>

                {{-- CTA Buttons: High-Contrast Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('lapangan.index') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-extrabold text-emerald-950 bg-emerald-400 hover:bg-emerald-300 shadow-xl shadow-emerald-950/40 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-400">
                        <span>Pesan Lapangan Sekarang</span>
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="#cara-kerja" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 rounded-xl text-base font-semibold text-slate-200 bg-slate-900/90 hover:bg-slate-800 border border-slate-700 transition-all">
                        Pelajari Alur Pemesanan
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="pt-6 border-t border-slate-800/80 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-950 border border-emerald-500/40 text-emerald-400 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="font-semibold text-slate-200">Konfirmasi Otomatis</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-950 border border-emerald-500/40 text-emerald-400 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="font-semibold text-slate-200">Kunci Slot Anti Bentrok</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-950 border border-emerald-500/40 text-emerald-400 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="font-semibold text-slate-200">QRIS & Virtual Account</span>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Card Visual Demonstrasi Booking Cepat (High-Craft Stadium Radar) --}}
            <div class="lg:col-span-5">
                <div class="bg-slate-900 border border-slate-700/80 rounded-3xl p-6 sm:p-7 shadow-2xl relative text-left">
                    {{-- Header Demo --}}
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                        <div class="flex items-center gap-2.5">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-bold text-slate-200 uppercase tracking-wider">Radar Slot Aktif</span>
                        </div>
                        <span class="text-xs font-bold text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-500/40 font-mono">
                            LIVE SYNC
                        </span>
                    </div>

                    {{-- Mock Lapangan Unggulan --}}
                    <div class="space-y-4">
                        <div class="rounded-2xl bg-slate-950 border border-slate-800 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="text-[11px] font-bold uppercase text-emerald-400 tracking-wider block">Futsal & Mini Soccer</span>
                                    <h4 class="font-bold text-white text-base mt-0.5">
                                        {{ $featuredLapangan->nama ?? 'Arena Futsal Premiere (Indoor)' }}
                                    </h4>
                                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $featuredLapangan->alamat ?? 'Rawamangun, Jakarta Timur' }}
                                    </p>
                                </div>
                                <span class="text-xs font-bold text-emerald-300 bg-emerald-950 border border-emerald-500/40 px-2.5 py-1 rounded-md shrink-0">
                                    Slot Buka
                                </span>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-slate-400 block text-[11px]">Jadwal Favorit</span>
                                    <span class="font-bold text-white font-mono">Hari Ini • 19:00 - 20:00 WIB</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-slate-400 block text-[11px]">Tarif Sewa</span>
                                    <span class="font-black text-emerald-400 text-sm font-mono tabular-nums">
                                        Rp {{ number_format($featuredLapangan->harga_per_jam ?? 150000, 0, ',', '.') }}
                                        <span class="font-normal text-[11px] text-slate-400">/jam</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Metode Pembayaran Bar --}}
                        <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-3.5 flex items-center justify-between text-xs">
                            <span class="text-slate-300 font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pembayaran Otomatis
                            </span>
                            <span class="font-bold text-slate-200 font-mono">QRIS • BCA VA • KASIR</span>
                        </div>

                        {{-- Action Link Menuju Halaman Booking --}}
                        <a href="{{ route('lapangan.index') }}" 
                           class="w-full block text-center py-3.5 bg-emerald-500 hover:bg-emerald-400 text-emerald-950 font-black text-xs rounded-xl shadow transition-colors uppercase tracking-wider">
                            Buka Halaman Pemesanan Lapangan &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 2. METRICS / STATISTIK KEPERCAYAAN --}}
<section class="bg-white border-b border-slate-200 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-100">
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-slate-900 font-mono tabular-nums">5</span>
                <span class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 block">Cabang Olahraga Siap Main</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-emerald-600 font-mono tabular-nums">100%</span>
                <span class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 block">Konfirmasi Instan Tanpa Antre</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-slate-900 font-mono tabular-nums">&lt; 1 Menit</span>
                <span class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 block">Waktu Selesai Booking</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-blue-600 font-mono tabular-nums">0 Double</span>
                <span class="text-xs sm:text-sm font-semibold text-slate-600 mt-1 block">Jaminan Kunci Slot Bentrok</span>
            </div>
        </div>
    </div>
</section>

{{-- 3. CABANG OLAHRAGA TERSEDIA (PALETTE DIVERSION & BESPOKE SVG ICONS) --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 block mb-1">Pilihan Cabang Olahraga</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Kategori Lapangan Tersedia</h2>
                <p class="text-sm text-slate-600 mt-1">Pilih cabang favorit Anda untuk melihat ketersediaan jadwal hari ini.</p>
            </div>
            <div>
                <a href="{{ route('lapangan.index') }}" class="inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700">
                    Lihat Seluruh Lapangan &rarr;
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            {{-- Futsal: Pitch Emerald --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'futsal']) }}" 
               class="group p-5 rounded-2xl border border-slate-200 bg-white hover:border-emerald-500 hover:shadow-lg transition-all text-center flex flex-col items-center">
                <div class="w-13 h-13 p-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-width="2" d="M12 7l3 2.5v5L12 17l-3-2.5v-5L12 7z"/>
                        <path stroke-width="1.8" d="M12 7V3m3 2.5l3.5-2m-8.5 2L6.5 3.5m5.5 13.5v4m3-2.5l3.5 2m-8.5-2L6.5 20.5"/>
                    </svg>
                </div>
                <span class="font-black text-slate-900 text-base group-hover:text-emerald-700 block">Futsal</span>
                <span class="text-xs text-emerald-600 font-bold mt-1 block">Vinyl & Interlock</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">5 Lapangan</span>
            </a>

            {{-- Badminton: Electric Indigo --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'badminton']) }}" 
               class="group p-5 rounded-2xl border border-slate-200 bg-white hover:border-indigo-500 hover:shadow-lg transition-all text-center flex flex-col items-center">
                <div class="w-13 h-13 p-3 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" d="M12 12c2.5 0 4.5-2 4.5-4.5S14.5 3 12 3 7.5 5 7.5 7.5 9.5 12 12 12z"/>
                        <path stroke-width="2" d="M12 12v9m-3-4l6 0"/>
                        <path stroke-width="1.5" d="M9 7.5h6M12 4.5v6"/>
                    </svg>
                </div>
                <span class="font-black text-slate-900 text-base group-hover:text-indigo-700 block">Badminton</span>
                <span class="text-xs text-indigo-600 font-bold mt-1 block">Karpet BWF Standar</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">5 Lapangan</span>
            </a>

            {{-- Basket: Court Amber --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'basket']) }}" 
               class="group p-5 rounded-2xl border border-slate-200 bg-white hover:border-amber-500 hover:shadow-lg transition-all text-center flex flex-col items-center">
                <div class="w-13 h-13 p-3 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-width="2" d="M3 12h18M12 3v18"/>
                        <path stroke-width="1.8" d="M5.5 5.5c4 4 4 9 0 13m13-13c-4 4-4 9 0 13"/>
                    </svg>
                </div>
                <span class="font-black text-slate-900 text-base group-hover:text-amber-700 block">Basket</span>
                <span class="text-xs text-amber-600 font-bold mt-1 block">Kayu Maple & FIBA</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">5 Lapangan</span>
            </a>

            {{-- Tenis: Baseline Lime --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'tenis']) }}" 
               class="group p-5 rounded-2xl border border-slate-200 bg-white hover:border-lime-600 hover:shadow-lg transition-all text-center flex flex-col items-center">
                <div class="w-13 h-13 p-3 rounded-2xl bg-lime-50 text-lime-700 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-width="2" d="M6 6c3 3 3 9 0 12m12-12c-3 3-3 9 0 12"/>
                    </svg>
                </div>
                <span class="font-black text-slate-900 text-base group-hover:text-lime-800 block">Tenis</span>
                <span class="text-xs text-lime-700 font-bold mt-1 block">Hard & Cushion</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">5 Lapangan</span>
            </a>

            {{-- Voli: Spike Sky Blue --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'voli']) }}" 
               class="group p-5 rounded-2xl border border-slate-200 bg-white hover:border-sky-500 hover:shadow-lg transition-all text-center flex flex-col items-center col-span-2 sm:col-span-1">
                <div class="w-13 h-13 p-3 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        <path stroke-width="1.8" d="M12 3a9 9 0 019 9M3 12a9 9 0 019 9m-9-9a9 9 0 019-9"/>
                    </svg>
                </div>
                <span class="font-black text-slate-900 text-base group-hover:text-sky-700 block">Bola Voli</span>
                <span class="text-xs text-sky-600 font-bold mt-1 block">Taraflex Anti-Slip</span>
                <span class="text-[11px] text-slate-500 mt-0.5 block">5 Lapangan</span>
            </a>
        </div>
    </div>
</section>

{{-- 4. VALUE PROPOSITION: KENAPA HARUS BOOKLAPANG? --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 block mb-2">Keunggulan Layanan</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Solusi Modern untuk Komunitas Olahraga</h2>
            <p class="text-sm sm:text-base text-slate-600 mt-2">
                Tinggalkan kerepotan tanya jadwal lewat WA. Kami hadir memberikan transparansi penuh untuk waktu tanding tim Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Feature 1 --}}
            <div class="bg-slate-50 rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:border-slate-300 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Jadwal Real-Time</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Ketersediaan jam slot diperbarui detik itu juga. Anda langsung tahu mana jam yang masih kosong dan siap dipesan.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-slate-50 rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:border-slate-300 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Kunci Slot Anti Bentrok</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Proteksi lock instan menjamin slot yang sedang Anda isi formulirnya tidak akan bisa direbut pengguna lain.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-slate-50 rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:border-slate-300 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">QRIS & VA Otomatis</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Scan via semua e-wallet atau bayar lewat Virtual Account BCA. Otomatis terkonfirmasi tanpa kirim screenshot slip.
                </p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-slate-50 rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-xs hover:border-slate-300 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Tiket Booking Digital</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Invoice dan QR check-in tersimpan aman di akun Anda. Tunjukkan QR saat tiba di lokasi untuk langsung bermain.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 5. CARA KERJA (ALUR 3 LANGKAH MUDAH) --}}
<section id="cara-kerja" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-slate-900 text-white border-y border-slate-800">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 block mb-2">Alur Pemesanan</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Hanya 3 Langkah untuk Mulai Main</h2>
            <p class="text-sm sm:text-base text-slate-300 mt-2">
                Tidak ada proses rumit. Dapatkan kepastian jadwal lapangan timmu dalam hitungan menit.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Step 1 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-slate-950 border border-slate-800 shadow-md">
                <div class="w-14 h-14 rounded-2xl bg-slate-800 text-white flex items-center justify-center text-xl font-black mb-5 font-mono">
                    01
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Pilih Venue & Olahraga</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Masuk ke katalog, pilih cabang olahraga favorit dan cari lokasi venue terdekat dengan tim Anda.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-slate-950 border border-slate-800 shadow-md">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-emerald-950 flex items-center justify-center text-xl font-black mb-5 font-mono">
                    02
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Pilih Tanggal & Jam</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Tentukan tanggal bermain dan klik slot jam yang masih berwarna hijau (Tersedia) pada kalender interaktif.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-slate-950 border border-slate-800 shadow-md">
                <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl font-black mb-5 font-mono">
                    03
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Bayar & Dapatkan Tiket</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Scan QRIS atau bayar Virtual Account. Tiket digital otomatis terbit dan lapangan siap digunakan!
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('lapangan.index') }}" 
               class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-sm font-extrabold text-emerald-950 bg-emerald-400 hover:bg-emerald-300 shadow-md transition-all">
                Mulai Pilih Lapangan Sekarang &rarr;
            </a>
        </div>
    </div>
</section>

{{-- 6. TESTIMONIAL DARI KOMUNITAS --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 block mb-2">Testimoni Komunitas</span>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Dipercaya Oleh Banyak Tim</h2>
            <p class="text-sm sm:text-base text-slate-600 mt-2">
                Lihat apa kata mereka yang sudah merasakan kepraktisan booking online di BookLapang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Testi 1 --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-500">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-700 italic leading-relaxed">
                        "Dulu sering banget drama tim udah siap di lapangan tapi ternyata jamnya bentrok sama orang lain. Di BookLapang begitu bayar via QRIS tiket langsung keluar, sangat terpercaya!"
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-xs font-mono">
                        BS
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 text-sm block">Budi Santoso</span>
                        <span class="text-xs text-slate-500 block">Kapten Futsal FC Jakarta</span>
                    </div>
                </div>
            </div>

            {{-- Testi 2 --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-500">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-700 italic leading-relaxed">
                        "Suka banget sama tampilannya yang bersih dan enteng. Jam-jam yang kosong kelihatan jelas banget per harinya. Nggak buang-buang waktu chat WA."
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center text-xs font-mono">
                        KP
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 text-sm block">Kevin Pratama</span>
                        <span class="text-xs text-slate-500 block">Koordinator Badminton Sudirman</span>
                    </div>
                </div>
            </div>

            {{-- Testi 3 --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex text-amber-500">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-700 italic leading-relaxed">
                        "Prosesnya bener-bener sat-set! Habis tanding kantor tiap hari Jumat langsung pesan slot buat minggu depannya lewat HP. Sangat direkomendasikan."
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-200 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-indigo-700 text-white font-bold flex items-center justify-center text-xs font-mono">
                        DP
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 text-sm block">Dwi Prasetyo</span>
                        <span class="text-xs text-slate-500 block">Komunitas Basket Senayan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 7. FAQ ACCORDION (INTERAKTIF) --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-slate-50 border-t border-slate-200" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 block mb-2">Pertanyaan Umum</span>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Sering Ditanyakan</h2>
            <p class="text-sm text-slate-600 mt-2">Punya pertanyaan sebelum memesan? Berikut penjelasan lengkapnya.</p>
        </div>

        <div class="space-y-3">
            {{-- FAQ 1 --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="w-full px-6 py-4 text-left font-bold text-slate-900 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50">
                    <span>Apakah saya harus membuat akun untuk memesan lapangan?</span>
                    <svg class="w-5 h-5 text-slate-500 transform transition-transform" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 1" x-collapse class="px-6 pb-4 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    Ya, Anda cukup mendaftar akun dalam 30 detik menggunakan nama, nomor HP, dan email. Akun ini berguna untuk menyimpan invoice, riwayat transaksi, dan bukti booking resmi.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="w-full px-6 py-4 text-left font-bold text-slate-900 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50">
                    <span>Bagaimana cara melakukan pembayaran?</span>
                    <svg class="w-5 h-5 text-slate-500 transform transition-transform" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 2" x-collapse class="px-6 pb-4 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    Kami menyediakan metode QRIS (bisa scan pakai GoPay, OVO, Dana, LinkAja, ShopeePay, dan mobile banking mana pun), Virtual Account BCA, serta opsi pembayaran tunai langsung di kasir lapangan.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="w-full px-6 py-4 text-left font-bold text-slate-900 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50">
                    <span>Apakah ada kemungkinan jadwal saya bertabrakan dengan penyewa lain?</span>
                    <svg class="w-5 h-5 text-slate-500 transform transition-transform" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 3" x-collapse class="px-6 pb-4 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    Tidak. Sistem kami menggunakan algoritma <em>pessimistic lock</em> pada level database. Begitu Anda memilih slot dan menekan tombol konfirmasi, slot tersebut otomatis dikunci dan ditutup untuk penyewa lain.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <button type="button" 
                        @click="activeAccordion = activeAccordion === 4 ? null : 4"
                        class="w-full px-6 py-4 text-left font-bold text-slate-900 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50">
                    <span>Bisakah saya membatalkan pesanan jika berhalangan hadir?</span>
                    <svg class="w-5 h-5 text-slate-500 transform transition-transform" :class="activeAccordion === 4 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="activeAccordion === 4" x-collapse class="px-6 pb-4 text-sm text-slate-600 border-t border-slate-100 pt-3">
                    Bisa. Selama status pesanan masih menunggu pembayaran (pending), Anda dapat membatalkannya langsung melalui halaman Dasbor & Riwayat Pesanan Anda.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 8. CLOSING CTA BANNER --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-slate-950 text-white border-t border-slate-800">
    <div class="max-w-5xl mx-auto text-center space-y-6">
        <span class="inline-block px-3.5 py-1 rounded-full bg-emerald-950 text-emerald-300 text-xs font-bold uppercase tracking-wider border border-emerald-500/30">
            SLOT WAKTU TERBATAS
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
            Siap Mengatur Jadwal Tanding Mingguan Timmu?
        </h2>
        <p class="text-slate-300 max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
            Amankan jam main favoritmu sebelum keduluan tim lain. Dapatkan kepastian jadwal dalam genggaman tangan Anda sekarang juga.
        </p>
        <div class="pt-4">
            <a href="{{ route('lapangan.index') }}" 
               class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-black text-emerald-950 bg-emerald-400 hover:bg-emerald-300 shadow-2xl transition-all transform hover:-translate-y-0.5">
                <span>Buka Katalog & Jadwal Lapangan</span>
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection