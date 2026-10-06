@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto" x-data="{ 
    paymentMethod: 'qris', 
    copied: false,
    timeLeft: 900,
    timerString: '15:00',
    init() {
        setInterval(() => {
            if (this.timeLeft > 0) {
                this.timeLeft--;
                const m = Math.floor(this.timeLeft / 60).toString().padStart(2, '0');
                const s = (this.timeLeft % 60).toString().padStart(2, '0');
                this.timerString = `${m}:${s}`;
            }
        }, 1000);
    },
    copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        this.copied = true;
        setTimeout(() => { this.copied = false; }, 2500);
    }
}">
    <div class="mb-6">
        <a href="{{ route('lapangan.show', $lapangan->id) }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-emerald-600 hover:text-emerald-700 transition-colors">
            &larr; Kembali ke Jadwal Lapangan
        </a>
    </div>

    {{-- Alert Batas Waktu Bayar 15 Menit dengan Live Countdown --}}
    <div class="mb-5 bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-center justify-between gap-4 shadow-xs">
        <div class="flex items-start gap-3">
            <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div>
                <strong class="font-bold block text-sm text-amber-950">Batas Waktu Reservasi</strong>
                <p class="text-xs text-amber-900 mt-0.5">
                    Slot dikunci eksklusif. Selesaikan pembayaran sebelum waktu habis.
                </p>
            </div>
        </div>
        <div class="text-right shrink-0">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 block">Sisa Waktu</span>
            <span class="text-lg font-black font-mono text-amber-950 tabular-nums" x-text="timerString">15:00</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden">
        <div class="p-6 sm:p-8 bg-slate-950 text-white">
            <span class="text-xs font-black uppercase tracking-widest text-emerald-400">Konfirmasi Pemesanan</span>
            <h1 class="text-2xl sm:text-3xl font-black mt-1 tracking-tight">Selesaikan Reservasi Lapangan</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">Pilih metode pembayaran dan tinjau rincian jadwal sebelum konfirmasi.</p>
        </div>

        <form action="{{ route('booking.store') }}" method="POST" class="p-6 sm:p-8">
            @csrf
            
            @php
                $slotList = isset($slots) ? $slots : collect([$slot]);
                $firstSlot = $slotList->first();
                $lastSlot = $slotList->last();
                $totalNominal = isset($totalHarga) ? $totalHarga : $slotList->sum(fn($s) => $s->harga_efektif);
            @endphp

            @foreach($slotList as $s)
                <input type="hidden" name="jadwal_slot_ids[]" value="{{ $s->id }}">
            @endforeach
            <input type="hidden" name="jadwal_slot_id" value="{{ $firstSlot->id }}">
            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

            {{-- Ringkasan Pesanan --}}
            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Detail Jadwal Terpilih</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Nama Lapangan</span>
                        <span class="font-black text-slate-900 text-base">{{ $lapangan->nama }}</span>
                        <span class="text-xs text-slate-500 block mt-0.5">{{ ucfirst($lapangan->tipe) }} &bull; {{ $lapangan->alamat }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider block">Tanggal Main</span>
                        <span class="font-black text-slate-900 text-base">
                            {{ \Carbon\Carbon::parse($firstSlot->tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="text-xs font-bold text-emerald-700 block mt-0.5 font-mono">
                            {{ substr($firstSlot->jam_mulai, 0, 5) }} - {{ substr($lastSlot->jam_selesai, 0, 5) }} WIB
                        </span>
                    </div>
                </div>

                {{-- Rincian Slot Jam yang Dipilih --}}
                <div class="border-t border-slate-200 pt-3">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">Slot Jam Dipilih ({{ count($slotList) }} Jam)</span>
                    <div class="space-y-1.5">
                        @foreach($slotList as $s)
                            <div class="flex items-center justify-between text-xs bg-white px-3.5 py-2.5 rounded-xl border border-slate-200">
                                <span class="font-bold text-slate-800 font-mono">
                                    Pukul {{ substr($s->jam_mulai, 0, 5) }} - {{ substr($s->jam_selesai, 0, 5) }} WIB
                                </span>
                                <span class="font-black text-slate-900 font-mono tabular-nums">
                                    Rp {{ number_format($s->harga_efektif, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
                    <span class="text-sm font-bold text-slate-700">Total Tagihan</span>
                    <span class="text-2xl font-black text-slate-900 font-mono tabular-nums">
                        Rp {{ number_format($totalNominal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Pilihan Metode Pembayaran --}}
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                    Pilih Metode Pembayaran
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                    {{-- QRIS --}}
                    <label class="border rounded-2xl p-3.5 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'qris' ? 'border-slate-900 bg-slate-900 text-white shadow-xs' : 'border-slate-200 bg-white text-slate-800 hover:border-slate-400'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-black">QRIS Instan</span>
                            <input type="radio" name="metode_pembayaran" value="qris" x-model="paymentMethod" class="text-emerald-500 focus:ring-emerald-500">
                        </div>
                        <span class="text-xs" :class="paymentMethod === 'qris' ? 'text-slate-300' : 'text-slate-500'">GoPay, BCA, OVO, Dana</span>
                    </label>

                    {{-- Virtual Account BCA --}}
                    <label class="border rounded-2xl p-3.5 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'transfer_bca' ? 'border-slate-900 bg-slate-900 text-white shadow-xs' : 'border-slate-200 bg-white text-slate-800 hover:border-slate-400'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-black">BCA Virtual Account</span>
                            <input type="radio" name="metode_pembayaran" value="transfer_bca" x-model="paymentMethod" class="text-emerald-500 focus:ring-emerald-500">
                        </div>
                        <span class="text-xs" :class="paymentMethod === 'transfer_bca' ? 'text-slate-300' : 'text-slate-500'">Otomatis via m-BCA / ATM</span>
                    </label>

                    {{-- Bayar Tunai --}}
                    <label class="border rounded-2xl p-3.5 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'cash' ? 'border-slate-900 bg-slate-900 text-white shadow-xs' : 'border-slate-200 bg-white text-slate-800 hover:border-slate-400'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-black">Bayar di Tempat</span>
                            <input type="radio" name="metode_pembayaran" value="cash" x-model="paymentMethod" class="text-emerald-500 focus:ring-emerald-500">
                        </div>
                        <span class="text-xs" :class="paymentMethod === 'cash' ? 'text-slate-300' : 'text-slate-500'">Kasir tunai lapangan</span>
                    </label>
                </div>

                {{-- PANEL VISUALISASI HASIL PEMBAYARAN (QRIS / VA) --}}
                
                {{-- 1. Panel QRIS --}}
                <div x-show="paymentMethod === 'qris'" x-transition class="bg-white border-2 border-emerald-500/40 rounded-2xl p-5 shadow-xs mb-6">
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        {{-- QR Code Visual (SVG High Res) --}}
                        <div class="bg-white p-3 border border-slate-200 rounded-xl shadow-xs flex flex-col items-center shrink-0">
                            <div class="text-[10px] font-black tracking-widest text-red-600 mb-1">QRIS STANDAR NASIONAL</div>
                            <svg class="w-40 h-40" viewBox="0 0 100 100" fill="currentColor">
                                <path fill-rule="evenodd" d="M0,0 h30 v30 h-30 z M5,5 h20 v20 h-20 z M10,10 h10 v10 h-10 z" />
                                <path fill-rule="evenodd" d="M70,0 h30 v30 h-30 z M75,5 h20 v20 h-20 z M80,10 h10 v10 h-10 z" />
                                <path fill-rule="evenodd" d="M0,70 h30 v30 h-30 z M5,75 h20 v20 h-20 z M10,80 h10 v10 h-10 z" />
                                <rect x="35" y="5" width="5" height="15" />
                                <rect x="45" y="10" width="15" height="5" />
                                <rect x="40" y="20" width="20" height="5" />
                                <rect x="10" y="35" width="15" height="5" />
                                <rect x="35" y="35" width="10" height="10" />
                                <rect x="50" y="35" width="5" height="15" />
                                <rect x="65" y="35" width="10" height="5" />
                                <rect x="80" y="35" width="15" height="10" />
                                <rect x="5" y="45" width="15" height="5" />
                                <rect x="35" y="50" width="15" height="5" />
                                <rect x="70" y="45" width="10" height="10" />
                                <rect x="25" y="55" width="10" height="10" />
                                <rect x="40" y="60" width="10" height="15" />
                                <rect x="55" y="55" width="15" height="5" />
                                <rect x="80" y="60" width="10" height="10" />
                                <rect x="35" y="70" width="5" height="20" />
                                <rect x="50" y="75" width="15" height="10" />
                                <rect x="70" y="75" width="20" height="5" />
                                <rect x="45" y="90" width="25" height="5" />
                                <rect x="75" y="85" width="15" height="10" />
                            </svg>
                            <div class="text-[9px] font-bold text-slate-500 mt-1 font-mono">NMID: ID102003920199</div>
                        </div>

                        {{-- Keterangan QRIS --}}
                        <div class="text-left w-full space-y-2 text-sm">
                            <div>
                                <span class="text-xs text-slate-500 uppercase tracking-wider block">Merchant Resmi</span>
                                <span class="font-bold text-slate-900 text-base">BookLapang Indonesia</span>
                            </div>
                            <div>
                                <span class="text-xs text-slate-500 uppercase tracking-wider block">Nominal Pembayaran</span>
                                <span class="font-black text-emerald-700 text-xl font-mono tabular-nums">Rp {{ number_format($totalNominal, 0, ',', '.') }}</span>
                            </div>
                            <div class="bg-emerald-50 text-emerald-950 text-xs p-3 rounded-xl border border-emerald-200">
                                <strong>Panduan Scan:</strong> Buka aplikasi m-Banking atau E-Wallet apa pun (GoPay, OVO, Dana, BCA), arahkan kamera ke QR code di atas, dan tagihan terverifikasi instan.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Panel Virtual Account BCA --}}
                @php
                    $cleanPhone = auth()->user()->no_hp ?? '81385084327';
                    $cleanPhone = preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $cleanPhone));
                    $vaNumber = '80777' . ($cleanPhone ?: '8123456789');
                @endphp
                <div x-show="paymentMethod === 'transfer_bca'" x-transition class="bg-white border-2 border-slate-300 rounded-2xl p-5 shadow-xs mb-6" style="display: none;">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <span class="text-xs font-black text-blue-900 uppercase tracking-wider block">Bank Central Asia (BCA)</span>
                                <span class="text-sm font-semibold text-slate-900">Virtual Account Pembayaran</span>
                            </div>
                            <span class="bg-blue-50 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-lg border border-blue-200 font-mono">BCA VA</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block mb-1 font-semibold">Nomor Virtual Account (VA)</span>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-slate-900 tracking-wider font-mono bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
                                    {{ $vaNumber }}
                                </span>
                                <button type="button" 
                                        x-show="!copied"
                                        @click="copyToClipboard('{{ $vaNumber }}')"
                                        class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-all flex items-center gap-1.5 bg-slate-100 text-slate-800 border-slate-300 hover:bg-slate-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    <span>Salin VA</span>
                                </button>
                                <button type="button" 
                                        x-show="copied"
                                        style="display: none;"
                                        class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-all flex items-center gap-1.5 bg-emerald-50 text-emerald-900 border-emerald-300">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    <span>Tersalin!</span>
                                </button>
                            </div>
                            <span class="text-xs text-slate-500 block mt-1.5">Atas Nama: <strong class="text-slate-800">BookLapang - {{ auth()->user()->name }}</strong></span>
                        </div>

                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs text-slate-600 space-y-1">
                            <p class="font-bold text-slate-800">Petunjuk Transfer m-BCA:</p>
                            <ol class="list-decimal list-inside space-y-0.5 pl-1">
                                <li>Buka menu <strong>m-Transfer</strong> &rarr; <strong>BCA Virtual Account</strong>.</li>
                                <li>Ketikkan nomor VA <span class="font-mono font-bold text-slate-900">{{ $vaNumber }}</span>.</li>
                                <li>Pastikan tagihan sesuai: <strong class="text-slate-900 font-mono">Rp {{ number_format($totalNominal, 0, ',', '.') }}</strong>, lalu masukkan PIN transaksi.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- 3. Panel Tunai --}}
                <div x-show="paymentMethod === 'cash'" x-transition class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs mb-6" style="display: none;">
                    <div class="text-sm text-slate-700 space-y-2">
                        <span class="font-bold text-slate-900 block">Pembayaran Tunai di Lokasi Lapangan</span>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Silakan datang ke meja kasir venue <strong>{{ $lapangan->nama }}</strong> paling lambat 15 menit sebelum kick-off jadwal Anda. Tunjukkan Kode Booking pada akun Anda untuk verifikasi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Catatan Tambahan --}}
            <div class="mb-8">
                <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Catatan Tambahan (Opsional)
                </label>
                <textarea id="catatan" 
                          name="catatan" 
                          rows="2" 
                          class="w-full border border-slate-300 rounded-xl p-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50/50"
                          placeholder="Contoh: Sewa 2 bola futsal tambahan atau rompi tim..."></textarea>
            </div>

            {{-- Tombol Aksi Konfirmasi --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('lapangan.show', $lapangan->id) }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-7 py-3 rounded-xl text-sm font-black text-white bg-slate-900 hover:bg-slate-800 shadow-md transition-all focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                    Kunci Jadwal & Selesaikan Pemesanan &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection