@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-16">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-emerald-600 hover:text-emerald-700 transition-colors">
            &larr; Kembali ke Riwayat Pesanan
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 hover:bg-slate-100 transition-colors shadow-xs">
            <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak / Simpan PDF
        </button>
    </div>

    {{-- KARTU E-TIKET DIGITAL (Aesthetic Match Ticket Stub) --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden relative print:shadow-none print:border-black">
        
        {{-- Header Tiket --}}
        <div class="bg-slate-950 text-white p-6 sm:p-8 relative overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                    <span class="text-xs font-black uppercase tracking-widest text-emerald-400">BookLapang Match Pass</span>
                </div>
                
                @if($booking->status === 'confirmed')
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-500 text-emerald-950 shadow-xs flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        TERKONFIRMASI
                    </span>
                @elseif($booking->status === 'done')
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-600 text-white shadow-xs">
                        SELESAI MAIN
                    </span>
                @elseif($booking->status === 'pending')
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-400 text-amber-950 shadow-xs">
                        MENUNGGU BAYAR
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-slate-700 text-white shadow-xs">
                        DIBATALKAN
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-1">
                {{ $booking->lapangan->nama }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                {{ $booking->lapangan->alamat }}
            </p>
        </div>

        {{-- Badan Tiket --}}
        <div class="p-6 sm:p-8 space-y-6">
            
            {{-- Kode Booking & Check-In Barcode Area --}}
            <div class="bg-slate-50 border border-slate-200/90 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest block">Kode Unik Reservasi</span>
                    <span class="text-3xl font-black text-slate-900 font-mono tracking-wider block mt-1">
                        {{ $booking->kode_booking ?? ('#BK-' . $booking->id) }}
                    </span>
                    <span class="text-xs text-slate-500 mt-1 block">Tunjukkan kode ini atau QR Code di samping kepada petugas kasir.</span>
                </div>

                {{-- QR Code Scanner SVG --}}
                <div class="bg-white p-3 rounded-xl border border-slate-300 shadow-xs shrink-0 flex flex-col items-center">
                    <svg class="w-28 h-28" viewBox="0 0 100 100" fill="currentColor">
                        <path fill-rule="evenodd" d="M0,0 h30 v30 h-30 z M5,5 h20 v20 h-20 z M10,10 h10 v10 h-10 z" />
                        <path fill-rule="evenodd" d="M70,0 h30 v30 h-30 z M75,5 h20 v20 h-20 z M80,10 h10 v10 h-10 z" />
                        <path fill-rule="evenodd" d="M0,70 h30 v30 h-30 z M5,75 h20 v20 h-20 z M10,80 h10 v10 h-10 z" />
                        <rect x="35" y="5" width="5" height="15" /><rect x="45" y="10" width="15" height="5" /><rect x="40" y="20" width="20" height="5" />
                        <rect x="10" y="35" width="15" height="5" /><rect x="35" y="35" width="10" height="10" /><rect x="50" y="35" width="5" height="15" />
                        <rect x="65" y="35" width="10" height="5" /><rect x="80" y="35" width="15" height="10" /><rect x="5" y="45" width="15" height="5" />
                        <rect x="35" y="50" width="15" height="5" /><rect x="70" y="45" width="10" height="10" /><rect x="25" y="55" width="10" height="10" />
                        <rect x="40" y="60" width="10" height="15" /><rect x="55" y="55" width="15" height="5" /><rect x="80" y="60" width="10" height="10" />
                        <rect x="35" y="70" width="5" height="20" /><rect x="50" y="75" width="15" height="10" /><rect x="70" y="75" width="20" height="5" />
                        <rect x="45" y="90" width="25" height="5" /><rect x="75" y="85" width="15" height="10" />
                    </svg>
                    <span class="text-[9px] font-black text-slate-500 block text-center mt-1 font-mono">SCAN TO CHECK-IN</span>
                </div>
            </div>

            {{-- Grid Rincian --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Nama Pemesan</span>
                    <span class="text-base font-bold text-slate-900 mt-0.5 block">{{ $booking->user->name }}</span>
                    <span class="text-xs text-slate-500">{{ $booking->user->email }}</span>
                </div>
                <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Cabang Olahraga</span>
                    <span class="text-base font-black text-slate-900 mt-0.5 block uppercase">{{ $booking->lapangan->tipe }}</span>
                    <span class="text-xs text-slate-500">Venue Resmi Terverifikasi</span>
                </div>
                <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Tanggal Reservasi</span>
                    <span class="text-base font-bold text-slate-900 mt-0.5 block">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="text-xs text-emerald-700 font-bold font-mono">
                        Pukul {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                    </span>
                </div>
                <div class="bg-slate-50/80 p-4 rounded-xl border border-slate-200">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Metode & Status Bayar</span>
                    <span class="text-base font-bold text-slate-900 mt-0.5 block uppercase">
                        {{ str_replace('_', ' ', $booking->metode_pembayaran) }}
                    </span>
                    <span class="text-xs font-black text-slate-900 font-mono tabular-nums">
                        Total: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Slot Rincian jika multi-slot --}}
            @if($booking->bookingSlots && $booking->bookingSlots->count() > 0)
                <div class="border-t border-slate-200 pt-4">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">
                        Rincian Jam Main ({{ $booking->bookingSlots->count() }} Slot Terdaftar)
                    </span>
                    <div class="space-y-1.5">
                        @foreach($booking->bookingSlots as $item)
                            <div class="flex items-center justify-between text-xs bg-slate-50 px-3.5 py-2.5 rounded-xl border border-slate-200">
                                <span class="font-bold text-slate-800 font-mono">
                                    {{ $item->jadwalSlot ? substr($item->jadwalSlot->jam_mulai, 0, 5) . ' - ' . substr($item->jadwalSlot->jam_selesai, 0, 5) . ' WIB' : 'Slot Terdaftar' }}
                                </span>
                                <span class="font-black text-slate-900 font-mono tabular-nums">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Panduan Check-In di Lokasi --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs text-slate-700 space-y-1.5">
                <span class="font-bold text-sm block text-slate-900">Panduan Masuk Lapangan:</span>
                <ul class="list-disc list-inside space-y-0.5 pl-1 text-slate-600">
                    <li>Datang minimal <strong>10-15 menit</strong> sebelum jadwal bermain dimulai.</li>
                    <li>Tunjukkan tiket ini atau sebutkan kode booking kepada petugas penjaga lapangan.</li>
                    <li>Gunakan sepatu olahraga yang sesuai dengan tipe permukaan lapangan.</li>
                </ul>
            </div>
        </div>

        {{-- Footer Tiket --}}
        <div class="bg-slate-100 p-4 text-center border-t border-slate-200 text-xs text-slate-500 font-mono">
            Diterbitkan oleh BookLapang &bull; Sistem Reservasi Lapangan Olahraga Real-Time
        </div>
    </div>
</div>
@endsection