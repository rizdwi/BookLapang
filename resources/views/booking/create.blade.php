@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto" x-data="{ 
    paymentMethod: 'qris', 
    copied: false,
    copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        this.copied = true;
        setTimeout(() => { this.copied = false; }, 2500);
    }
}">
    <div class="mb-6">
        <a href="{{ route('lapangan.show', $lapangan->id) }}" class="inline-flex items-center text-sm font-semibold text-[#0d9488] hover:text-[#0f766e]">
            &larr; Kembali ke Jadwal Lapangan
        </a>
    </div>

    {{-- Alert Batas Waktu Bayar 15 Menit --}}
    <div class="mb-5 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="text-xs text-amber-900">
            <strong class="font-bold block text-sm">Batas Pembayaran: 15 Menit</strong>
            Slot yang Anda pilih akan dikunci sementara. Jika pembayaran tidak diselesaikan dalam 15 menit sejak pesanan dibuat, sistem akan otomatis membatalkan pesanan dan membuka kembali jadwal untuk orang lain.
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 sm:p-8 bg-[#1e3a5f] text-white">
            <span class="text-xs font-bold uppercase tracking-widest text-teal-300">Konfirmasi Pemesanan</span>
            <h1 class="text-2xl sm:text-3xl font-black mt-1">Selesaikan Reservasi Lapangan</h1>
            <p class="text-sm text-slate-200 mt-1">Pilih metode pembayaran dan tinjau rincian jadwal sebelum konfirmasi.</p>
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
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">Detail Jadwal Terpilih</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="text-xs text-gray-500 block">Nama Lapangan</span>
                        <span class="font-bold text-[#1e3a5f] text-base">{{ $lapangan->nama }}</span>
                        <span class="text-xs text-gray-500 block mt-0.5">{{ ucfirst($lapangan->tipe) }} &bull; {{ $lapangan->alamat }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">Tanggal Sewa</span>
                        <span class="font-bold text-gray-900 text-base">
                            {{ \Carbon\Carbon::parse($firstSlot->tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="text-xs font-semibold text-teal-700 block mt-0.5">
                            Rentang: {{ substr($firstSlot->jam_mulai, 0, 5) }} - {{ substr($lastSlot->jam_selesai, 0, 5) }} WIB
                        </span>
                    </div>
                </div>

                {{-- Rincian Slot Jam yang Dipilih --}}
                <div class="border-t border-gray-200 pt-3">
                    <span class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-2">Slot Jam Dipilih ({{ count($slotList) }} Jam)</span>
                    <div class="space-y-1.5">
                        @foreach($slotList as $s)
                            <div class="flex items-center justify-between text-xs bg-white px-3 py-2 rounded-lg border border-gray-200">
                                <span class="font-semibold text-gray-800">
                                    Pukul {{ substr($s->jam_mulai, 0, 5) }} - {{ substr($s->jam_selesai, 0, 5) }} WIB
                                </span>
                                <span class="font-bold text-teal-700">
                                    Rp {{ number_format($s->harga_efektif, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-700">Total Tagihan</span>
                    <span class="text-2xl font-black text-[#1e3a5f]">
                        Rp {{ number_format($totalNominal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Pilihan Metode Pembayaran --}}
            <div class="mb-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-3">
                    Pilih Metode Pembayaran
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                    {{-- QRIS --}}
                    <label class="border rounded-xl p-3 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'qris' ? 'border-teal-600 bg-teal-50 ring-1 ring-teal-600' : 'border-gray-200 hover:border-teal-300'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">QRIS Instan</span>
                            <input type="radio" name="metode_pembayaran" value="qris" x-model="paymentMethod" class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Scan via GoPay, BCA, OVO, Dana</span>
                    </label>

                    {{-- Virtual Account BCA --}}
                    <label class="border rounded-xl p-3 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'transfer_bca' ? 'border-teal-600 bg-teal-50 ring-1 ring-teal-600' : 'border-gray-200 hover:border-teal-300'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">BCA Virtual Account</span>
                            <input type="radio" name="metode_pembayaran" value="transfer_bca" x-model="paymentMethod" class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Konfirmasi otomatis via m-BCA/ATM</span>
                    </label>

                    {{-- Bayar Tunai --}}
                    <label class="border rounded-xl p-3 flex flex-col cursor-pointer transition-all"
                           :class="paymentMethod === 'cash' ? 'border-teal-600 bg-teal-50 ring-1 ring-teal-600' : 'border-gray-200 hover:border-teal-300'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-bold text-gray-900">Bayar di Tempat</span>
                            <input type="radio" name="metode_pembayaran" value="cash" x-model="paymentMethod" class="text-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                        <span class="text-xs text-gray-500">Bayar tunai di kasir lapangan</span>
                    </label>
                </div>

                {{-- PANEL VISUALISASI HASIL PEMBAYARAN (QRIS / VA) --}}
                
                {{-- 1. Panel QRIS --}}
                <div x-show="paymentMethod === 'qris'" x-transition class="bg-white border-2 border-teal-500/40 rounded-xl p-5 shadow-sm mb-6">
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        {{-- QR Code Visual (SVG High Res) --}}
                        <div class="bg-white p-3 border border-gray-300 rounded-lg shadow-sm flex flex-col items-center shrink-0">
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
                            <div class="text-[9px] font-bold text-gray-500 mt-1">NMID: ID102003920199</div>
                        </div>

                        {{-- Keterangan QRIS --}}
                        <div class="text-left w-full space-y-2 text-sm">
                            <div>
                                <span class="text-xs text-gray-500 uppercase tracking-wider block">Merchant Resmi</span>
                                <span class="font-bold text-[#1e3a5f] text-base">BookLapang Indonesia</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 uppercase tracking-wider block">Nominal Pembayaran</span>
                                <span class="font-black text-emerald-700 text-lg">Rp {{ number_format($totalNominal, 0, ',', '.') }}</span>
                            </div>
                            <div class="bg-teal-50 text-teal-800 text-xs p-2.5 rounded-lg border border-teal-200">
                                <strong>Panduan:</strong> Buka aplikasi m-Banking atau E-Wallet pilihan Anda (GoPay, OVO, Dana, BCA Mobile), scan QR code di atas, dan tagihan akan terverifikasi.
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
                <div x-show="paymentMethod === 'transfer_bca'" x-transition class="bg-white border-2 border-teal-500/40 rounded-xl p-5 shadow-sm mb-6" style="display: none;">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <div>
                                <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block">Bank Central Asia (BCA)</span>
                                <span class="text-sm font-semibold text-gray-900">Virtual Account Pembayaran</span>
                            </div>
                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded">BCA VA</span>
                        </div>

                        <div>
                            <span class="text-xs text-gray-500 block mb-1">Nomor Virtual Account (VA)</span>
                            <div class="flex items-center gap-2">
                                <span class="text-2xl font-black text-[#1e3a5f] tracking-wider font-mono bg-gray-50 px-3 py-1.5 rounded border border-gray-200">
                                    {{ $vaNumber }}
                                </span>
                                <button type="button" 
                                        @click="copyToClipboard('{{ $vaNumber }}')"
                                        class="px-3 py-2 rounded-lg text-xs font-bold border transition-all flex items-center gap-1"
                                        :class="copied ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'">
                                    <template x-if="!copied">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                            Salin Nomor VA
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Tersalin!
                                        </span>
                                    </template>
                                </button>
                            </div>
                            <span class="text-xs text-gray-500 block mt-1.5">Atas Nama: <strong>BookLapang - {{ auth()->user()->name }}</strong></span>
                        </div>

                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-xs text-gray-600 space-y-1">
                            <p class="font-bold text-gray-800">Cara Transfer via m-BCA:</p>
                            <ol class="list-decimal list-inside space-y-0.5 pl-1">
                                <li>Pilih menu <strong>m-Transfer</strong> &rarr; <strong>BCA Virtual Account</strong>.</li>
                                <li>Masukkan nomor Virtual Account <span class="font-mono font-bold">{{ $vaNumber }}</span>.</li>
                                <li>Periksa nominal tagihan sebesar <strong>Rp {{ number_format($totalNominal, 0, ',', '.') }}</strong>, lalu konfirmasi PIN Anda.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- 3. Panel Tunai --}}
                <div x-show="paymentMethod === 'cash'" x-transition class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-6" style="display: none;">
                    <div class="text-sm text-gray-700 space-y-2">
                        <span class="font-bold text-gray-900 block">Pembayaran Tunai di Lokasi Lapangan</span>
                        <p class="text-xs text-gray-600">
                            Silakan datang ke kasir venue <strong>{{ $lapangan->nama }}</strong> paling lambat 15 menit sebelum jam main pertama. Tunjukkan Kode Booking Anda untuk menyelesaikan administrasi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Catatan Tambahan --}}
            <div class="mb-8">
                <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Catatan Tambahan (Opsional)
                </label>
                <textarea id="catatan" 
                          name="catatan" 
                          rows="2" 
                          class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488]"
                          placeholder="Contoh: Pinjam 2 bola futsal, atau sewa rompi tim..."></textarea>
            </div>

            {{-- Tombol Aksi Konfirmasi --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('lapangan.show', $lapangan->id) }}" 
                   class="px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                    Konfirmasi & Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
