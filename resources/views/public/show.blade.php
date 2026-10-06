@extends('layouts.app')

@section('content')
<div x-data="{
    selectedSlots: [],
    toggleSlot(id, jam, price) {
        const index = this.selectedSlots.findIndex(s => s.id === id);
        if (index > -1) {
            this.selectedSlots.splice(index, 1);
        } else {
            this.selectedSlots.push({ id, jam, price });
        }
    },
    isSelected(id) {
        return this.selectedSlots.some(s => s.id === id);
    },
    get totalPrice() {
        return this.selectedSlots.reduce((sum, s) => sum + s.price, 0);
    },
    formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    },
    get checkoutUrl() {
        const ids = this.selectedSlots.map(s => s.id).join(',');
        return '{{ route('booking.create') }}?slot_ids=' + ids;
    }
}">

{{-- Navigasi Balik --}}
<div class="mb-6">
    <a href="{{ route('lapangan.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-emerald-600 hover:text-emerald-700 transition-colors">
        &larr; Kembali ke Daftar Lapangan
    </a>
</div>

{{-- Detail Lapangan Card (Bolder Athletic Header) --}}
<div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 overflow-hidden mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 h-64 lg:h-auto relative bg-slate-900">
            <img class="h-full w-full object-cover" src="{{ $lapangan->foto_url }}" alt="{{ $lapangan->nama }}" loading="lazy">
            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider bg-slate-950/90 text-white backdrop-blur-xs border border-white/10 shadow-xs">
                    {{ ucfirst($lapangan->tipe) }}
                </span>
                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-white/95 text-slate-800 backdrop-blur-xs shadow-xs">
                    {{ $lapangan->wilayah }}
                </span>
            </div>
        </div>
        <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2 border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $lapangan->nama }}</h1>
                        <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $lapangan->alamat }}</span>
                        </p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold block">Tarif Sewa Standar</span>
                        <span class="text-2xl font-black text-slate-900 font-mono tabular-nums">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-slate-500">/ jam</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi & Fasilitas</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $lapangan->deskripsi }}</p>
                </div>

                {{-- Skema Tarif Jam Sibuk (Peak / Non-Peak) jika ada --}}
                @if($lapangan->tarifs && $lapangan->tarifs->count() > 0)
                    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <span class="text-xs font-black uppercase tracking-wider text-amber-900 block mb-2">
                            Skema Tarif Khusus / Jam Sibuk (Dynamic Pricing)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-amber-950">
                            @foreach($lapangan->tarifs as $trf)
                                <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-amber-200">
                                    <span class="font-semibold text-amber-950">{{ $trf->label ?? ucfirst($trf->tipe_hari) }} ({{ substr($trf->jam_mulai, 0, 5) }} - {{ substr($trf->jam_selesai, 0, 5) }})</span>
                                    <span class="font-black text-amber-950 font-mono tabular-nums">Rp {{ number_format($trf->harga, 0, ',', '.') }}/jam</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs text-slate-700 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Anda bisa <strong class="text-slate-900">memilih lebih dari satu jam main sekaligus</strong> dalam 1 kali reservasi.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal & Pemilihan Slot Jam --}}
<div class="bg-white rounded-2xl shadow-xs border border-slate-200/90 p-6 sm:p-8 mb-28">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-black text-slate-900">Ketersediaan Jadwal</h2>
            <p class="text-sm text-slate-600 mt-0.5">Pilih tanggal dan centang jam main yang Anda inginkan (bisa multi-jam berturut-turut).</p>
        </div>

        {{-- Form Pemilihan Tanggal --}}
        <form action="{{ route('lapangan.show', $lapangan->id) }}" method="GET" class="flex items-center gap-2">
            <div>
                <label for="tanggal" class="sr-only">Pilih Tanggal</label>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ $selectedDate }}" 
                       min="{{ date('Y-m-d') }}" 
                       class="border border-slate-300 rounded-xl py-2 px-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-xs font-semibold bg-slate-50">
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 shadow-xs transition-colors">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Grid Slot Jam --}}
    @if(isset($jadwal_slots) && count($jadwal_slots) > 0)
        <div class="mb-4">
            <div class="flex items-center gap-4 text-xs font-semibold text-slate-600 mb-6">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-slate-900 ring-2 ring-emerald-400"></span> Dipilih
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-slate-300"></span> Terisi / Ditutup
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($jadwal_slots as $slot)
                    @php
                        $slotPrice = $slot->harga_efektif;
                        $slotJam = substr($slot->jam_mulai, 0, 5) . ' - ' . substr($slot->jam_selesai, 0, 5);
                    @endphp
                    
                    @if($slot->tersedia)
                        <div @click="toggleSlot({{ $slot->id }}, '{{ $slotJam }}', {{ $slotPrice }})"
                             :class="isSelected({{ $slot->id }}) ? 'border-slate-900 bg-slate-900 text-white ring-2 ring-emerald-400 shadow-md' : 'border-slate-200 bg-white hover:border-emerald-500 hover:shadow-xs'"
                             class="border rounded-2xl p-4 flex flex-col justify-between transition-all cursor-pointer select-none relative group">
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base font-black font-mono"
                                      :class="isSelected({{ $slot->id }}) ? 'text-white' : 'text-slate-900 group-hover:text-emerald-700'">
                                    {{ $slotJam }}
                                </span>
                                <template x-if="isSelected({{ $slot->id }})">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-emerald-500 text-emerald-950 shadow-xs flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        Dipilih
                                    </span>
                                </template>
                                <template x-if="!isSelected({{ $slot->id }})">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        Tersedia
                                    </span>
                                </template>
                            </div>

                            <div class="text-xs mb-4 flex items-center justify-between"
                                 :class="isSelected({{ $slot->id }}) ? 'text-slate-300' : 'text-slate-500'">
                                <span>Tarif:</span>
                                <span class="font-black text-sm font-mono tabular-nums"
                                      :class="isSelected({{ $slot->id }}) ? 'text-emerald-400' : 'text-slate-900'">
                                    Rp {{ number_format($slotPrice, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="pt-2 border-t flex items-center justify-between text-xs font-semibold"
                                 :class="isSelected({{ $slot->id }}) ? 'border-slate-800 text-emerald-400' : 'border-slate-100 text-slate-500 group-hover:text-emerald-700'">
                                <span x-text="isSelected({{ $slot->id }}) ? 'Batalkan Pilihan' : '+ Klik untuk Memilih'"></span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="border border-slate-200 bg-slate-50 opacity-60 rounded-2xl p-4 flex flex-col justify-between cursor-not-allowed">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base font-bold text-slate-400 font-mono">
                                    {{ $slotJam }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-200 text-slate-600">
                                    Terisi
                                </span>
                            </div>
                            <div class="text-xs text-slate-400 mb-4">
                                Tidak dapat dipesan
                            </div>
                            <button type="button" disabled class="w-full py-2 border border-slate-200 text-xs font-semibold rounded-xl text-slate-400 bg-slate-100 cursor-not-allowed text-center">
                                Sudah Terisi
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="py-12 text-center border border-dashed border-slate-300 rounded-2xl">
            <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h4 class="text-base font-bold text-slate-900">Belum ada slot jadwal pada tanggal ini</h4>
            <p class="text-sm text-slate-500 mt-1">Silakan pilih tanggal lain yang tercantum di atas.</p>
        </div>
    @endif
</div>

{{-- FLOATING BOTTOM BAR (MULTI-SLOT DOCK WITH HIGH CONTRAST) --}}
<div x-show="selectedSlots.length > 0" 
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 inset-x-0 z-40 bg-slate-950/95 text-white backdrop-blur-md border-t border-slate-800 shadow-2xl py-4 px-4 sm:px-6 lg:px-8"
     style="display: none;">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-emerald-950 font-black flex items-center justify-center text-lg shadow-xs font-mono">
                <span x-text="selectedSlots.length"></span>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Slot Jam Dipilih</span>
                <div class="text-sm font-black text-white flex flex-wrap gap-1.5 items-center">
                    <template x-for="slot in selectedSlots" :key="slot.id">
                        <span class="px-2 py-0.5 rounded bg-slate-800 border border-slate-700 text-xs font-mono font-semibold text-emerald-400" x-text="slot.jam"></span>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
            <div class="text-right">
                <span class="text-xs text-slate-400 uppercase tracking-wider block font-semibold">Total Biaya</span>
                <span class="text-xl sm:text-2xl font-black text-white font-mono tabular-nums" x-text="formatRupiah(totalPrice)"></span>
            </div>
            <a :href="checkoutUrl"
               class="px-6 sm:px-8 py-3 bg-emerald-400 hover:bg-emerald-300 text-emerald-950 font-extrabold rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 text-sm sm:text-base flex items-center gap-2">
                <span>Lanjut ke Pembayaran</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>

</div>
@endsection