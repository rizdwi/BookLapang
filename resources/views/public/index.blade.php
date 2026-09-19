@extends('layouts.app')

@section('content')
<div class="mb-10 text-center">
    <h1 class="text-4xl font-extrabold text-[#1e3a5f] mb-4">Booking Lapangan Olahraga</h1>
    <p class="text-lg text-[#64748b] max-w-2xl mx-auto">Pesan lapangan futsal, badminton, basket, voli, dan tenis dengan mudah dan cepat. Pastikan jadwal Anda tersedia hari ini.</p>
</div>

<div class="mb-8">
    <h2 class="text-2xl font-bold text-[#1a1a1a] mb-6">Daftar Lapangan Tersedia</h2>
    
    @if(isset($lapangan) && count($lapangan) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lapangan as $lap)
                <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                    @if($lap->foto)
                        <img src="{{ asset('storage/' . $lap->foto) }}" alt="Foto {{ $lap->nama }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                            Tidak ada foto
                        </div>
                    @endif
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-[#1e3a5f]">{{ $lap->nama }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f8fafc] text-[#1e3a5f] border border-[#1e3a5f]">
                                {{ ucfirst($lap->tipe) }}
                            </span>
                        </div>
                        <p class="text-sm text-[#64748b] mb-4 line-clamp-2">{{ $lap->deskripsi }}</p>
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-lg font-bold text-[#1a1a1a]">Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}<span class="text-sm font-normal text-[#64748b]">/jam</span></span>
                            <a href="{{ route('lapangan.show', $lap->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-10 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-[#1a1a1a]">Tidak ada lapangan</h3>
            <p class="mt-1 text-sm text-[#64748b]">Belum ada data lapangan yang tersedia saat ini.</p>
        </div>
    @endif
</div>
@endsection
