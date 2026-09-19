@extends('layouts.app')

@section('content')
<div x-data="{ 
    paymentModalOpen: false,
    modalData: {
        id: '',
        lapangan: '',
        total: '',
        method: 'qris',
        vaNumber: '',
        date: ''
    },
    copied: false,
    openPayment(id, lapangan, total, method, va, date) {
        this.modalData = { id, lapangan, total, method, vaNumber: va, date };
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
        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg text-white bg-[#0d9488] hover:bg-[#0f766e] shadow-sm transition-colors">
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
            <h3 class="text-xl font-black text-[#1e3a5f]" x-text="'Pesanan #' + modalData.id"></h3>
            <p class="text-xs text-gray-500" x-text="modalData.lapangan + ' • ' + modalData.date"></p>
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
            <button type="button" @click="paymentModalOpen = false" class="w-full py-2 bg-[#1e3a5f] text-white rounded-lg text-sm font-semibold hover:bg-slate-800">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Metric Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Total Pesanan</span>
        <span class="text-2xl font-black text-[#1e3a5f] mt-1 block">{{ $totalBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider block">Menunggu Pembayaran</span>
        <span class="text-2xl font-black text-amber-600 mt-1 block">{{ $pendingBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-teal-600 uppercase tracking-wider block">Dikonfirmasi</span>
        <span class="text-2xl font-black text-teal-600 mt-1 block">{{ $confirmedBookings ?? 0 }}</span>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider block">Selesai</span>
        <span class="text-2xl font-black text-emerald-600 mt-1 block">{{ $doneBookings ?? 0 }}</span>
    </div>
</div>

{{-- Tabel Riwayat Booking --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-bold text-[#1e3a5f]">Daftar Riwayat Booking</h2>
        <span class="text-xs text-gray-500">Menampilkan seluruh riwayat</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3.5">ID & Waktu Main</th>
                    <th class="px-6 py-3.5">Lapangan</th>
                    <th class="px-6 py-3.5">Metode Bayar</th>
                    <th class="px-6 py-3.5">Total Tarif</th>
                    <th class="px-6 py-3.5">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $booking)
                        @php
                            $cleanPhone = auth()->user()->phone ? preg_replace('/^0/', '', preg_replace('/[^0-9]/', '', auth()->user()->phone)) : '81385084327';
                            $vaNum = '80777' . $cleanPhone;
                            $formattedTotal = 'Rp ' . number_format($booking->total_harga, 0, ',', '.');
                            $formattedDate = \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y');
                            $bookingIdPadded = str_pad($booking->id, 4, '0', STR_PAD_LEFT);
                            $metodeBayar = $booking->metode_pembayaran ?? 'qris';
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-[#1e3a5f] block">#BK-{{ $bookingIdPadded }}</span>
                                <span class="text-gray-900 font-medium block mt-0.5">{{ $formattedDate }}</span>
                                <span class="text-xs text-teal-700 font-semibold block">
                                    {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($booking->lapangan && $booking->lapangan->foto)
                                        <img src="{{ asset('storage/' . $booking->lapangan->foto) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" alt="">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-400">No Img</div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-gray-900 block">{{ $booking->lapangan->nama ?? 'Lapangan' }}</span>
                                        <span class="text-xs text-gray-500 block">{{ ucfirst($booking->lapangan->tipe ?? '-') }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="uppercase text-xs font-bold text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                    {{ str_replace('_', ' ', $metodeBayar) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-black text-[#1e3a5f] text-base">{{ $formattedTotal }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$booking->status" />
                            </td>

                            {{-- Tombol Aksi Pelanggan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-semibold">
                                @if($booking->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" 
                                                @click="openPayment('{{ $bookingIdPadded }}', '{{ addslashes($booking->lapangan->nama) }}', '{{ $formattedTotal }}', '{{ $metodeBayar }}', '{{ $vaNum }}', '{{ $formattedDate }}')"
                                                class="text-white bg-[#0d9488] hover:bg-[#0f766e] px-2.5 py-1.5 rounded font-bold shadow-sm transition-colors">
                                            Bayar Sekarang
                                        </button>

                                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded border border-red-200 transition-colors">
                                                Batal
                                            </button>
                                        </form>
                                    </div>
                                @elseif($booking->status === 'confirmed')
                                    <span class="inline-flex items-center gap-1 text-teal-700 bg-teal-50 px-2.5 py-1.5 rounded text-xs font-medium border border-teal-200">
                                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Siap Main
                                    </span>
                                @else
                                    <a href="{{ route('lapangan.show', $booking->lapangan_id) }}" class="text-[#0d9488] hover:text-[#0f766e] bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded transition-colors">
                                        Pesan Lagi
                                    </a>
                                @endif
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
