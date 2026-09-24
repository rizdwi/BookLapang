@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mb-16">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">Check-In Scanner Lapangan</h1>
            <p class="text-sm text-[#64748b]">Verifikasi kedatangan pemain di venue menggunakan Kode Booking atau QR Tiket.</p>
        </div>
        <a href="{{ route('admin.booking.index') }}" class="text-sm font-semibold text-[#0d9488] hover:text-[#0f766e]">
            &larr; Data Booking
        </a>
    </div>

    {{-- Form Pencarian Kode Tiket --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm mb-8">
        <form action="{{ route('admin.checkin.view') }}" method="GET" class="space-y-4">
            <label for="code" class="block text-xs font-bold uppercase tracking-wider text-gray-700">
                Masukkan / Scan Kode Tiket Booking
            </label>
            <div class="flex gap-2">
                <div class="relative flex-grow">
                    <input type="text" 
                           name="code" 
                           id="code" 
                           value="{{ $code ?? '' }}" 
                           placeholder="Contoh: BK-260924-A1B2 atau 1" 
                           autofocus
                           class="w-full border border-gray-300 rounded-xl py-3 pl-11 pr-4 text-base font-mono font-bold focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm uppercase">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <button type="submit" class="px-6 py-3 bg-[#1e3a5f] hover:bg-slate-800 text-white rounded-xl text-sm font-bold shadow-sm transition-colors shrink-0">
                    Cek Tiket
                </button>
            </div>
            <p class="text-xs text-gray-500">Anda dapat mengetik kode reservasi atau menggunakan barcode scanner USB/Bluetooth.</p>
        </form>
    </div>

    {{-- Hasil Pemeriksaan Tiket --}}
    @if(!empty($code))
        @if($foundBooking)
            <div class="bg-white rounded-2xl shadow-md border-2 {{ $foundBooking->status === 'done' ? 'border-blue-400' : ($foundBooking->status === 'confirmed' ? 'border-emerald-500' : 'border-amber-400') }} overflow-hidden">
                <div class="p-6 sm:p-7 {{ $foundBooking->status === 'done' ? 'bg-blue-50/50' : ($foundBooking->status === 'confirmed' ? 'bg-emerald-50/50' : 'bg-amber-50/50') }} border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Hasil Tiket Ditemukan</span>
                        <h2 class="text-2xl font-black text-[#1e3a5f] font-mono mt-0.5">
                            {{ $foundBooking->kode_booking ?? ('#BK-' . $foundBooking->id) }}
                        </h2>
                    </div>
                    <x-status-badge :status="$foundBooking->status" />
                </div>

                <div class="p-6 sm:p-7 space-y-5">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-500 block uppercase font-semibold">Nama Pemesan</span>
                            <span class="font-bold text-gray-900 text-base block mt-0.5">{{ $foundBooking->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $foundBooking->user->email }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block uppercase font-semibold">Venue Lapangan</span>
                            <span class="font-bold text-[#1e3a5f] text-base block mt-0.5">{{ $foundBooking->lapangan->nama }}</span>
                            <span class="text-xs text-gray-500 uppercase font-semibold">{{ $foundBooking->lapangan->tipe }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-xs text-gray-500 block uppercase font-semibold">Tanggal & Jam Main</span>
                            <span class="font-bold text-gray-900 block mt-0.5">
                                {{ \Carbon\Carbon::parse($foundBooking->tanggal_booking)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-xs text-teal-700 font-bold">
                                {{ substr($foundBooking->jam_mulai, 0, 5) }} - {{ substr($foundBooking->jam_selesai, 0, 5) }} WIB
                            </span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 block uppercase font-semibold">Total Tagihan & Metode</span>
                            <span class="font-black text-emerald-700 text-base block mt-0.5">
                                Rp {{ number_format($foundBooking->total_harga, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-gray-600 uppercase font-semibold">
                                {{ str_replace('_', ' ', $foundBooking->metode_pembayaran) }}
                            </span>
                        </div>
                    </div>

                    {{-- Form Aksi Check-In --}}
                    <div class="pt-6 border-t border-gray-200">
                        @if($foundBooking->status === 'confirmed')
                            <form action="{{ route('admin.checkin.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $foundBooking->id }}">
                                <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-base font-black shadow-lg shadow-emerald-900/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Verifikasi & Konfirmasi Check-In Pemain</span>
                                </button>
                            </form>
                        @elseif($foundBooking->status === 'done')
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl text-center text-xs font-bold text-blue-900 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Pemain sudah selesai check-in. Lapangan siap digunakan!
                            </div>
                        @elseif($foundBooking->status === 'pending')
                            <div class="p-4 bg-amber-50 border border-amber-300 rounded-xl text-xs text-amber-900 space-y-2">
                                <span class="font-bold block">Status Pesanan: Masih Menunggu Pembayaran</span>
                                <p>Pastikan pemain telah melunasi tagihan di kasir sebelum melakukan konfirmasi check-in.</p>
                                <form action="{{ route('admin.booking.update-status', $foundBooking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="done">
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs">
                                        Terima Kasir Tunai & Langsung Check-In
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-center text-xs font-bold text-red-800">
                                Tiket ini telah dibatalkan dan tidak dapat digunakan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl p-8 border border-dashed border-gray-300 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h3 class="text-base font-bold text-gray-900">Kode Booking "{{ $code }}" Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1">Periksa kembali penulisan kode atau pastikan kode booking sudah benar.</p>
            </div>
        @endif
    @endif
</div>
@endsection
