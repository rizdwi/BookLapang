@extends('layouts.app')

@section('content')
<div x-data="{ 
    paymentModalOpen: false,
    modalData: {
        id: '',
        kode: '',
        lapangan: '',
        total: '',
        method: 'qris',
        vaNumber: '',
        date: ''
    },
    copied: false,
    openPayment(id, kode, lapangan, total, method, va, date) {
        this.modalData = { id, kode, lapangan, total, method, vaNumber: va, date };
        this.paymentModalOpen = true;
        this.copied = false;
    },
    copyVa() {
        navigator.clipboard.writeText(this.modalData.vaNumber);
        this.copied = true;
        setTimeout(() => { this.copied = false; }, 2000);
    }
}">

{{-- Header --}}
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Dasbor & Riwayat Pesanan</h1>
        <p class="text-sm text-[#64748b]">Selamat datang kembali, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span>! Pantau status reservasi lapanganmu di sini.</p>
    </div>
    <div>
        <a href="{{ route('lapangan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors">
            + Pesan Lapangan Baru
        </a>
    </div>
</div>

{{-- MODAL INSTRUKSI PEMBAYARAN (QRIS / BCA VA) --}}
<div x-show="paymentModalOpen" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" 
     style="display: none;"
     x-transition>
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative" @click.outside="paymentModalOpen = false">
        <button @click="paymentModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        <div class="text-center mb-4">
            <span class="text-xs font-bold text-teal-600 uppercase tracking-widest block">Tagihan Pembayaran</span>
            <h3 class="text-xl font-black text-[#1e3a5f]" x-text="modalData.kode"></h3>
            <p class="text-xs text-gray-500 mt-0.5" x-text="modalData.lapangan + ' • ' + modalData.date"></p>
            <div class="text-2xl font-black text-emerald-700 mt-2" x-text="modalData.total"></div>
        </div>

        {{-- Jika QRIS --}}
        <template x-if="modalData.method === 'qris'">
            <div class="flex flex-col items-center bg-gray-50 p-4 rounded-xl border border-gray-200">
                <div class="bg-white p-3 border border-gray-300 rounded-lg shadow-sm flex flex-col items-center mb-3">
                    <div class="text-[9px] font-black tracking-widest text-red-600 mb-1">QRIS STANDAR NASIONAL</div>
                    <svg class="w-44 h-44" viewBox="0 0 100 100" fill="currentColor">
                        <path fill-rule="evenodd" d="M0,0 h30 v30 h-30 z M5,5 h20 v20 h-20 z M10,10 h10 v10 h-10 z" />
                        <path fill-rule="evenodd" d="M70,0 h30 v30 h-30 z M75,5 h20 v20 h-20 z M80,10 h10 v10 h-10 z" />
                        <path fill-rule="evenodd" d="M0,70 h30 v30 h-30 z M5,75 h20 v20 h-20 z M10,80 h10 v10 h-10 z" />
                        <rect x="35" y="5" width="5" height="15" /><rect x="45" y="10" width="15" height="5" /><rect x="40" y="20" width="20" height="5" />
                        <rect x="10" y="35" width="15" height="5" /><rect x="35" y="35" width="10" height="10" /><rect x="50" y="35" width="5" height="15" />
                        <rect x="65" y="35" width="10" height="5" /><rect x="80" y="35" width="15" height="10" /><rect x="5" y="45" width="15" height="5" />
                        <rect x="35" y="50" width="15" height="5" /><rect x="70" y="45" width="10" height="10" /><rect x="25" y="55" width="10" height="10" />
                        <rect x="40" y="60" width="10" height="15" /><rect x="55" y="55" width="15" height="5" /><rect x="80" y="60" width="10" height="10" />
                        <rect x="35" y="70" width="5" height="20" /><rect x="50" y="75" width="15" height="10" /><rect x="70" y="75" width="20" height="5" />
                    </svg>
                    <span class="text-[9px] font-bold text-gray-500 mt-1">BookLapang Official</span>
                </div>
                <p class="text-xs text-gray-600 text-center">Buka aplikasi E-Wallet atau mobile banking Anda dan scan QR Code di atas.</p>
            </div>
        </template>

        {{-- Jika Transfer BCA --}}
        <template x-if="modalData.method === 'transfer_bca'">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-left space-y-3">
                <span class="text-xs font-bold text-blue-800 uppercase block">BCA Virtual Account</span>
                <div class="flex items-center justify-between bg-white border border-gray-300 p-2.5 rounded-lg">
                    <span class="font-mono font-black text-lg text-gray-900" x-text="modalData.vaNumber"></span>
                    <button type="button" @click="copyVa()" class="text-xs font-bold px-2.5 py-1 rounded bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-100">
                        <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Transfer via m-BCA &rarr; m-Transfer &rarr; BCA Virtual Account dengan nominal persis tertera.</p>
            </div>
        </template>

        {{-- Jika Tunai --}}
        <template x-if="modalData.method === 'cash'">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-left">
                <p class="text-sm text-gray-700">Silakan bayar tunai di kasir lapangan saat tiba di lokasi. Tunjukkan ID pesanan Anda kepada petugas.</p>
            </div>
        </template>

        <div class="mt-5">
            <button type="button" @click="paymentModalOpen = false" class="w-full py-2 bg-[#1e3a5f] text-white rounded-xl text-sm font-semibold hover:bg-slate-800">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Pesanan</span>
        <span class="text-2xl font-black text-[#1e3a5f] mt-1 block">{{ $totalBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider block">Menunggu Pembayaran</span>
        <span class="text-2xl font-black text-amber-600 mt-1 block">{{ $pendingBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-teal-600 uppercase tracking-wider block">Dikonfirmasi</span>
        <span class="text-2xl font-black text-teal-600 mt-1 block">{{ $confirmedBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider block">Selesai</span>
        <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $doneBookings ?? 0 }}</span>
    </div>
</div>

{{-- Tabel Riwayat Booking --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-12">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-bold text-[#1e3a5f]">Daftar Riwayat Booking</h2>
        <span class="text-xs text-gray-500">Menampilkan seluruh reservasi Anda</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">Kode & Jadwal Main</th>
                    <th class="px-6 py-3.5">Lapangan</th>
                    <th class="px-6 py-3.5">Metode Bayar</th>
                    <th class="px-6 py-3.5">Total Tagihan</th>
                    <th class="px-6 py-3.5">Status & Timer</th>
                    <th class="px-6 py-3.5 text-right">Aksi & Tiket</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $booking)
                        @php
                            $cleanPhone = auth()->user()->no_hp ?? '81385084327';
                            $cleanPhone = preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', $cleanPhone));
                            $vaNum = '80777' . ($cleanPhone ?: '8123456789');
                            $formattedTotal = 'Rp ' . number_format($booking->total_harga, 0, ',', '.');
                            $formattedDate = \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y');
                            $kodeBooking = $booking->kode_booking ?? ('#BK-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT));
                            $metodeBayar = $booking->metode_pembayaran ?? 'qris';
                            $remainingSec = $booking->remainingSeconds();
                            
                            // Teks WhatsApp Share
                            $waShareText = rawurlencode("Halo gaes! Kita sudah booking lapangan di BookLapang:\n\n"
                                . "🏟️ Lapangan: " . ($booking->lapangan->nama ?? 'Lapangan') . "\n"
                                . "📅 Tanggal: " . $formattedDate . "\n"
                                . "⏰ Jam: " . substr($booking->jam_mulai, 0, 5) . " - " . substr($booking->jam_selesai, 0, 5) . " WIB\n"
                                . "📋 Kode Tiket: " . $kodeBooking . "\n\n"
                                . "Jangan lupa hadir tepat waktu ya!");
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-black text-[#1e3a5f] block text-sm">{{ $kodeBooking }}</span>
                                <span class="text-gray-900 font-semibold block mt-0.5">{{ $formattedDate }}</span>
                                <span class="text-xs text-teal-700 font-bold block">
                                    {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                    @if($booking->bookingSlots->count() > 1)
                                        <span class="text-[10px] bg-teal-100 text-teal-800 px-1.5 py-0.5 rounded ml-1">
                                            {{ $booking->bookingSlots->count() }} Jam
                                        </span>
                                    @endif
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($booking->lapangan)
                                        <img src="{{ $booking->lapangan->foto_url }}" class="w-10 h-10 rounded-xl object-cover border border-gray-200" alt="{{ $booking->lapangan->nama }}" loading="lazy">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-xs text-gray-400">No Img</div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-gray-900 block">{{ $booking->lapangan->nama ?? 'Lapangan' }}</span>
                                        <span class="text-xs text-gray-500 block uppercase font-semibold">{{ $booking->lapangan->tipe ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="uppercase text-xs font-bold text-gray-700 bg-gray-100 px-2.5 py-1 rounded-lg">
                                    {{ str_replace('_', ' ', $metodeBayar) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-black text-[#1e3a5f] text-base">{{ $formattedTotal }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />

                                {{-- Countdown Timer untuk Status Pending --}}
                                @if($booking->status === 'pending')
                                    <div x-data="{
                                        secondsLeft: {{ $remainingSec }},
                                        timerText: '',
                                        init() {
                                            this.updateDisplay();
                                            if (this.secondsLeft > 0) {
                                                const timer = setInterval(() => {
                                                    this.secondsLeft--;
                                                    this.updateDisplay();
                                                    if (this.secondsLeft <= 0) {
                                                        clearInterval(timer);
                                                        window.location.reload();
                                                    }
                                                }, 1000);
                                            }
                                        },
                                        updateDisplay() {
                                            if (this.secondsLeft <= 0) {
                                                this.timerText = 'Kadaluarsa';
                                                return;
                                            }
                                            const m = Math.floor(this.secondsLeft / 60);
                                            const s = this.secondsLeft % 60;
                                            this.timerText = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
                                        }
                                    }" class="mt-1 flex items-center gap-1 text-[11px] font-mono text-amber-700 font-bold">
                                        <svg class="w-3 h-3 text-amber-600 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="timerText"></span>
                                    </div>
                                @endif
                            </td>

                            {{-- Tombol Aksi & Tiket --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                    {{-- Tombol E-Tiket Digital --}}
                                    <a href="{{ route('booking.ticket', $booking->id) }}" 
                                       class="px-2.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors flex items-center gap-1 font-bold">
                                        <svg class="w-3.5 h-3.5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                        Tiket
                                    </a>

                                    {{-- Share WA ke Tim jika Confirmed / Done --}}
                                    @if(in_array($booking->status, ['confirmed', 'done']))
                                        <a href="https://wa.me/?text={{ $waShareText }}" 
                                           target="_blank" 
                                           class="px-2.5 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition-colors flex items-center gap-1 font-bold"
                                           title="Bagikan jadwal ke tim via WhatsApp">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.85 2.791.85 3.181 0 5.767-2.586 5.767-5.766.001-3.182-2.585-5.836-5.767-5.836zm3.393 8.232c-.146.41-1.044.823-1.442.846-.388.022-.725-.09-2.333-.74-1.921-.778-3.155-2.73-3.251-2.859-.096-.13-.775-1.03-.775-1.964s.484-1.391.656-1.583c.172-.191.376-.239.502-.239.125 0 .252.002.361.008.117.006.273-.044.428.328.16.386.549 1.341.597 1.439.049.098.082.213.016.342-.066.13-.098.212-.196.326-.098.115-.207.257-.295.345-.098.098-.201.205-.087.401.115.196.509.84 1.092 1.36.751.67 1.385.877 1.581.975.196.098.311.082.426-.049.115-.131.492-.573.623-.77.131-.197.262-.164.442-.098.18.066 1.147.541 1.344.639.197.098.328.147.376.23.049.082.049.475-.097.885z"/></svg>
                                            WA Tim
                                        </a>
                                    @endif

                                    @if($booking->status === 'pending')
                                        <button type="button" 
                                                @click="openPayment('{{ $booking->id }}', '{{ $kodeBooking }}', '{{ addslashes($booking->lapangan->nama) }}', '{{ $formattedTotal }}', '{{ $metodeBayar }}', '{{ $vaNum }}', '{{ $formattedDate }}')"
                                                class="text-white bg-[#0d9488] hover:bg-[#0f766e] px-2.5 py-1.5 rounded-lg font-bold shadow-sm transition-colors">
                                            Bayar
                                        </button>

                                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-2 py-1.5 rounded-lg border border-red-200 transition-colors">
                                                Batal
                                            </button>
                                        </form>
                                    @elseif($booking->status !== 'confirmed')
                                        <a href="{{ route('lapangan.show', $booking->lapangan_id) }}" class="text-[#0d9488] hover:text-[#0f766e] bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Pesan Lagi
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum Ada Riwayat Pemesanan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</div>{{-- End Alpine x-data scope --}}
@endsection
