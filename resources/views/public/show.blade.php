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
    <a href="{{ route('lapangan.index') }}" class="inline-flex items-center text-sm font-semibold text-[#0d9488] hover:text-[#0f766e]">
        &larr; Kembali ke Daftar Lapangan
    </a>
</div>

{{-- Detail Lapangan Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 h-64 lg:h-auto relative bg-gray-100">
            @if($lapangan->foto)
                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $lapangan->foto) }}" alt="{{ $lapangan->nama }}">
            @else
                <div class="h-full w-full flex items-center justify-center text-gray-400">
                    Tidak ada foto
                </div>
            @endif
            <span class="absolute top-4 left-4 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-[#1e3a5f]/90 text-white backdrop-blur-sm">
                {{ ucfirst($lapangan->tipe) }}
            </span>
        </div>
        <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2 border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1e3a5f]">{{ $lapangan->nama }}</h1>
                        <p class="text-sm text-[#64748b] mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $lapangan->alamat }}
                        </p>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs text-[#64748b] block">Tarif Sewa Standar</span>
                        <span class="text-2xl font-black text-[#1e3a5f]">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-[#64748b]">/ jam</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 mb-2">Deskripsi & Fasilitas</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $lapangan->deskripsi }}</p>
                </div>

                {{-- Skema Tarif Jam Sibuk (Peak / Non-Peak) jika ada --}}
                @if($lapangan->tarifs && $lapangan->tarifs->count() > 0)
                    <div class="mb-6 bg-amber-50/70 border border-amber-200/80 rounded-xl p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-900 block mb-2">
                            Skema Tarif Khusus / Jam Sibuk (Dynamic Pricing)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-amber-950">
                            @foreach($lapangan->tarifs as $trf)
                                <div class="flex items-center justify-between bg-white/70 px-3 py-2 rounded-lg border border-amber-200/50">
                                    <span>{{ $trf->label ?? ucfirst($trf->tipe_hari) }} ({{ substr($trf->jam_mulai, 0, 5) }} - {{ substr($trf->jam_selesai, 0, 5) }})</span>
                                    <span class="font-bold">Rp {{ number_format($trf->harga, 0, ',', '.') }}/jam</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-teal-50 border border-teal-100 rounded-xl p-3.5 text-xs text-teal-900 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Anda bisa <strong>memilih lebih dari satu jam main sekaligus</strong> dalam 1 transaksi.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal & Pemilihan Slot Jam --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 mb-24">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-6 mb-6">
        <div>
            <h2 class="text-xl font-bold text-[#1e3a5f]">Ketersediaan Jadwal</h2>
            <p class="text-sm text-[#64748b]">Pilih tanggal dan centang jam main yang Anda inginkan (bisa multi-jam berturut-turut).</p>
        </div>

        {{-- Form Pemilihan Tanggal --}}
        <form action="{{ route('lapangan.show', $lapangan->id) }}" method="GET" class="flex items-center gap-3">
            <div>
                <label for="tanggal" class="sr-only">Pilih Tanggal</label>
                <input type="date" 
                       name="tanggal" 
                       id="tanggal" 
                       value="{{ $selectedDate }}" 
                       min="{{ date('Y-m-d') }}" 
                       class="border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-[#0d9488] focus:border-[#0d9488] shadow-sm font-medium">
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-[#1e3a5f] hover:bg-slate-800 shadow-sm transition-colors">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Grid Slot Jam --}}
    @if(isset($jadwal_slots) && count($jadwal_slots) > 0)
        <div class="mb-4">
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-6">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia (Klik untuk memilih)
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-teal-500 ring-2 ring-teal-200"></span> Dipilih Anda
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-gray-300"></span> Terisi / Tidak Tersedia
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
                             :class="isSelected({{ $slot->id }}) ? 'border-teal-600 bg-teal-50/60 ring-2 ring-teal-500 shadow-md' : 'border-gray-200 bg-white hover:border-teal-400 hover:shadow-sm'"
                             class="border rounded-2xl p-4 flex flex-col justify-between transition-all cursor-pointer select-none relative group">
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base font-black text-gray-900 group-hover:text-teal-700 transition-colors">
                                    {{ $slotJam }}
                                </span>
                                <template x-if="isSelected({{ $slot->id }})">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-black bg-teal-600 text-white shadow-sm flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        Dipilih
                                    </span>
                                </template>
                                <template x-if="!isSelected({{ $slot->id }})">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Tersedia
                                    </span>
                                </template>
                            </div>

                            <div class="text-xs text-gray-500 mb-4 flex items-center justify-between">
                                <span>Tarif:</span>
                                <span class="font-bold text-gray-900 text-sm">
                                    Rp {{ number_format($slotPrice, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-xs font-semibold"
                                 :class="isSelected({{ $slot->id }}) ? 'text-teal-800' : 'text-gray-500 group-hover:text-teal-600'">
                                <span x-text="isSelected({{ $slot->id }}) ? 'Batalkan Pilihan' : '+ Klik untuk Memilih'"></span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="border border-gray-100 bg-gray-50 opacity-70 rounded-2xl p-4 flex flex-col justify-between cursor-not-allowed">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base font-bold text-gray-400">
                                    {{ $slotJam }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-gray-200 text-gray-600">
                                    Terisi
                                </span>
                            </div>
                            <div class="text-xs text-gray-400 mb-4">
                                Tidak dapat dipesan
                            </div>
                            <button type="button" disabled class="w-full py-2 border border-gray-200 text-xs font-medium rounded-xl text-gray-400 bg-gray-100 cursor-not-allowed text-center">
                                Sudah Terisi
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="py-12 text-center border border-dashed border-gray-200 rounded-2xl">
            <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h4 class="text-base font-bold text-gray-900">Belum ada slot jadwal pada tanggal ini</h4>
            <p class="text-sm text-gray-500 mt-1">Silakan pilih tanggal lain yang tercantum di atas.</p>
        </div>
    @endif
</div>

{{-- FLOATING BOTTOM BAR (MULTI-SLOT CHECKOUT BAR) --}}
<div x-show="selectedSlots.length > 0" 
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200 shadow-2xl py-4 px-4 sm:px-6 lg:px-8"
     style="display: none;">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-teal-600 text-white font-black flex items-center justify-center text-lg shadow-sm">
                <span x-text="selectedSlots.length"></span>
            </div>
            <div>
                <span class="text-xs text-gray-500 font-bold uppercase tracking-wider block">Jam Dipilih</span>
                <div class="text-sm font-black text-[#1e3a5f] flex flex-wrap gap-1.5 items-center">
                    <template x-for="slot in selectedSlots" :key="slot.id">
                        <span class="px-2 py-0.5 rounded bg-gray-100 border border-gray-200 text-xs font-semibold" x-text="slot.jam"></span>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
            <div class="text-right">
                <span class="text-xs text-gray-500 uppercase tracking-wider block font-semibold">Total Biaya</span>
                <span class="text-xl sm:text-2xl font-black text-[#1e3a5f]" x-text="formatRupiah(totalPrice)"></span>
            </div>
            <a :href="checkoutUrl"
               class="px-6 sm:px-8 py-3 bg-[#0d9488] hover:bg-[#0f766e] text-white font-bold rounded-xl shadow-lg shadow-teal-900/20 transition-all transform hover:-translate-y-0.5 text-sm sm:text-base flex items-center gap-2">
                <span>Lanjut Booking</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>

</div>
@endsection
