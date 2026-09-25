@extends('layouts.app')

@section('full_width', true)

@section('content')
{{-- 1. HERO SECTION (Minimalist, Persuasif & Fokus Konversi) --}}
<section class="relative bg-gradient-to-b from-[#1e3a5f] via-[#162e4c] to-[#0f2138] text-white pt-16 pb-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    {{-- Glow aksen halus di background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-25">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-teal-400 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-32 w-80 h-80 bg-blue-500 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            {{-- Kolom Kiri: Value Proposition & CTA --}}
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                {{-- Badge Status Platform --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/10 border border-teal-400/30 text-teal-300 text-xs font-bold tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    Sistem Reservasi Lapangan Bebas Ribet
                </div>

                {{-- Headline Utama --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight sm:leading-none text-white">
                    Main Kapan Saja, <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-300 to-teal-200">
                        Booking Lapangan
                    </span> <br class="hidden sm:inline">
                    Tanpa Takut Bentrok.
                </h1>

                {{-- Deskripsi Nilai Tambah --}}
                <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Platform cerdas untuk cek jadwal kosong detik ini juga, amankan slot main timmu, dan bayar otomatis via QRIS atau Virtual Account. Tanpa chat WhatsApp manual, 100% kepastian waktu main.
                </p>

                {{-- CTA Buttons: Mengarahkan langsung ke halaman booking terpisah --}}
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('lapangan.index') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-extrabold text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-xl shadow-teal-950/40 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <span>Pesan Lapangan Sekarang</span>
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="#cara-kerja" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 rounded-xl text-base font-semibold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/15 transition-all">
                        Pelajari Alur Pemesanan
                    </a>
                </div>

                {{-- Trust Badges --}}
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

            {{-- Kolom Kanan: Card Visual Demonstrasi Booking Cepat --}}
            <div class="lg:col-span-5">
                <div class="bg-white/95 backdrop-blur text-gray-900 rounded-3xl p-6 sm:p-7 shadow-2xl border border-white/20 relative">
                    {{-- Header Demo --}}
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-5">
                        <div class="flex items-center gap-2.5">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Ketersediaan Real-Time</span>
                        </div>
                        <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full border border-teal-100">
                            {{ $totalLapangan ?? 5 }} Lapangan Aktif
                        </span>
                    </div>

                    {{-- Mock Lapangan Unggulan --}}
                    <div class="space-y-4">
                        <div class="rounded-2xl bg-gray-50 border border-gray-200 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="text-[11px] font-bold uppercase text-teal-600 tracking-wider block">Cabang Futsal & Mini Soccer</span>
                                    <h4 class="font-bold text-[#1e3a5f] text-base mt-0.5">
                                        {{ $featuredLapangan->nama ?? 'Arena Futsal Premiere (Indoor)' }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $featuredLapangan->alamat ?? 'Rawamangun, Jakarta Timur' }}
                                    </p>
                                </div>
                                <span class="text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md shrink-0">
                                    Slot Buka
                                </span>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-200/80 flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-gray-400 block">Jadwal Favorit</span>
                                    <span class="font-bold text-gray-800">Hari Ini • 19:00 - 20:00 WIB</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-gray-400 block">Tarif Sewa</span>
                                    <span class="font-black text-[#1e3a5f] text-sm">
                                        Rp {{ number_format($featuredLapangan->harga_per_jam ?? 150000, 0, ',', '.') }}
                                        <span class="font-normal text-[11px] text-gray-500">/jam</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Metode Pembayaran Bar --}}
                        <div class="bg-teal-50/70 border border-teal-100 rounded-xl p-3 flex items-center justify-between text-xs">
                            <span class="text-teal-900 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Bayar Otomatis
                            </span>
                            <span class="font-bold text-teal-800">QRIS • BCA Virtual Account</span>
                        </div>

                        {{-- Action Link Menuju Halaman Booking --}}
                        <a href="{{ route('lapangan.index') }}" 
                           class="w-full block text-center py-3.5 bg-[#1e3a5f] hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition-colors uppercase tracking-wider">
                            Buka Halaman Pemesanan Lapangan &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 2. METRICS / STATISTIK KEPERCAYAAN --}}
<section class="bg-white border-b border-gray-200 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-[#1e3a5f]">5+</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Cabang Olahraga Tersedia</span>
            </div>
            <div class="pt-4 md:pt-0">
                <span class="block text-3xl sm:text-4xl font-black text-[#0d9488]">100%</span>
                <span class="text-xs sm:text-sm font-semibold text-gray-500 mt-1 block">Konfirmasi Instan Tanpa Antre</span>
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

{{-- 3. VALUE PROPOSITION: KENAPA HARUS BOOKLAPANG? --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-[#f8fafc]">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Keunggulan Layanan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#1e3a5f] tracking-tight">Solusi Modern untuk Penggiat Olahraga</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Tinggalkan kerepotan tanya jadwal lewat WA. Kami hadir memberikan transparansi penuh untuk waktu tanding tim Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-[#0d9488] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Jadwal Real-Time</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Ketersediaan jam slot diperbarui detik itu juga. Anda langsung tahu mana jam yang masih kosong dan siap dipesan.
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Anti Double-Booking</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem database dengan proteksi <em>lock</em> instan menjamin slot yang Anda ambil tidak akan bisa dipesan pengguna lain.
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">QRIS & VA Instan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Scan via GoPay, OVO, Dana, ShopeePay atau bayar lewat Virtual Account BCA. Terverifikasi tanpa kirim struk transfer.
                </p>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Tiket Booking Digital</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Seluruh riwayat dan tiket tersimpan di akun Anda. Cukup tunjukkan ID pesanan di HP saat tiba di lokasi lapangan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 4. CABANG OLAHRAGA TERSEDIA (PREVIEW JELAJAH) --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-1">Pilihan Olahraga</span>
                <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Cabang Olahraga yang Didukung</h2>
                <p class="text-sm text-gray-600 mt-1">Pilih cabang favorit Anda dan jelajahi lapangan yang tersedia di halaman booking.</p>
            </div>
            <div>
                <a href="{{ route('lapangan.index') }}" class="inline-flex items-center text-sm font-bold text-[#0d9488] hover:text-[#0f766e]">
                    Lihat Seluruh Lapangan &rarr;
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            {{-- Futsal --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'futsal']) }}" 
               class="group p-5 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-teal-500 hover:shadow-md transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-teal-100/70 text-teal-800 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    ⚽
                </div>
                <span class="font-extrabold text-[#1e3a5f] text-base group-hover:text-teal-700 block">Futsal</span>
                <span class="text-xs text-[#0d9488] font-bold mt-0.5 block">5 Lokasi Venue</span>
                <span class="text-[11px] text-gray-500 mt-0.5 block">Indoor & Vinyl</span>
            </a>

            {{-- Badminton --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'badminton']) }}" 
               class="group p-5 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-teal-500 hover:shadow-md transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-100/70 text-emerald-800 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    🏸
                </div>
                <span class="font-extrabold text-[#1e3a5f] text-base group-hover:text-teal-700 block">Badminton</span>
                <span class="text-xs text-[#0d9488] font-bold mt-0.5 block">5 Lokasi Venue</span>
                <span class="text-[11px] text-gray-500 mt-0.5 block">Karpet BWF</span>
            </a>

            {{-- Basket --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'basket']) }}" 
               class="group p-5 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-teal-500 hover:shadow-md transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-amber-100/70 text-amber-800 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    🏀
                </div>
                <span class="font-extrabold text-[#1e3a5f] text-base group-hover:text-teal-700 block">Basket</span>
                <span class="text-xs text-[#0d9488] font-bold mt-0.5 block">5 Lokasi Venue</span>
                <span class="text-[11px] text-gray-500 mt-0.5 block">Kayu Maple & FIBA</span>
            </a>

            {{-- Tenis --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'tenis']) }}" 
               class="group p-5 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-teal-500 hover:shadow-md transition-all text-center flex flex-col items-center">
                <div class="w-12 h-12 rounded-xl bg-blue-100/70 text-blue-800 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    🎾
                </div>
                <span class="font-extrabold text-[#1e3a5f] text-base group-hover:text-teal-700 block">Tenis</span>
                <span class="text-xs text-[#0d9488] font-bold mt-0.5 block">5 Lokasi Venue</span>
                <span class="text-[11px] text-gray-500 mt-0.5 block">Hard & Cushion Court</span>
            </a>

            {{-- Voli --}}
            <a href="{{ route('lapangan.index', ['tipe' => 'voli']) }}" 
               class="group p-5 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-teal-500 hover:shadow-md transition-all text-center flex flex-col items-center col-span-2 sm:col-span-1">
                <div class="w-12 h-12 rounded-xl bg-purple-100/70 text-purple-800 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform">
                    🏐
                </div>
                <span class="font-extrabold text-[#1e3a5f] text-base group-hover:text-teal-700 block">Bola Voli</span>
                <span class="text-xs text-[#0d9488] font-bold mt-0.5 block">5 Lokasi Venue</span>
                <span class="text-[11px] text-gray-500 mt-0.5 block">Taraflex Anti-Slip</span>
            </a>
        </div>
    </div>
</section>

{{-- 5. CARA KERJA (ALUR 3 LANGKAH MUDAH) --}}
<section id="cara-kerja" class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-[#f8fafc] border-y border-gray-200">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Alur Pemesanan</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Hanya 3 Langkah untuk Mulai Main</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Tidak ada proses rumit. Dapatkan kepastian jadwal lapangan timmu dalam hitungan menit.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            {{-- Step 1 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-[#1e3a5f] text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    1
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Buka Halaman Booking</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Masuk ke halaman katalog, cari cabang olahraga dan lokasi venue lapangan yang paling cocok untuk tim Anda.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-[#0d9488] text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    2
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Pilih Tanggal & Jam</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Tentukan tanggal bermain dan klik slot jam yang masih berwarna hijau (Tersedia) pada kalender interaktif.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="relative flex flex-col items-center text-center p-7 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl font-black mb-5 shadow">
                    3
                </div>
                <h3 class="text-lg font-bold text-[#1e3a5f] mb-2">Bayar & Datang Main</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Scan QRIS atau transfer Virtual Account BCA. Tiket digital otomatis terbit dan lapangan siap Anda gunakan!
                </p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('lapangan.index') }}" 
               class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl text-sm font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-md transition-colors">
                Mulai Pilih Lapangan Sekarang &rarr;
            </a>
        </div>
    </div>
</section>

{{-- 6. TESTIMONIAL DARI KOMUNITAS --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Testimoni Komunitas</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Dipercaya Oleh Banyak Tim</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2">
                Lihat apa kata mereka yang sudah merasakan kepraktisan booking online di BookLapang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Testi 1 --}}
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 flex flex-col justify-between">
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
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 flex flex-col justify-between">
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
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 flex flex-col justify-between">
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

{{-- 7. FAQ ACCORDION (INTERAKTIF) --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-[#f8fafc] border-t border-gray-200" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-[#0d9488] block mb-2">Pertanyaan Umum</span>
            <h2 class="text-3xl font-extrabold text-[#1e3a5f] tracking-tight">Sering Ditanyakan</h2>
            <p class="text-sm text-gray-600 mt-2">Punya pertanyaan sebelum memesan? Berikut penjelasan lengkapnya.</p>
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

{{-- 8. CLOSING CTA BANNER: MENGAJAK MASUK KE HALAMAN BOOKING --}}
<section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-[#1e3a5f] via-[#162e4c] to-[#0d9488] text-white">
    <div class="max-w-5xl mx-auto text-center space-y-6">
        <span class="inline-block px-3.5 py-1 rounded-full bg-white/10 text-teal-300 text-xs font-bold uppercase tracking-wider">
            Slot Waktu Terbatas
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
            Siap Mengatur Jadwal Tanding Mingguan Timmu?
        </h2>
        <p class="text-slate-200 max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
            Amankan jam main favoritmu sebelum keduluan tim lain. Dapatkan kepastian jadwal dalam genggaman tangan Anda sekarang juga.
        </p>
        <div class="pt-4">
            <a href="{{ route('lapangan.index') }}" 
               class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-black text-[#1e3a5f] bg-white hover:bg-teal-50 shadow-2xl transition-all transform hover:-translate-y-0.5">
                <span>Buka Halaman Pemesanan Lapangan</span>
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
