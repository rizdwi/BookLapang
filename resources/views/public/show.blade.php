@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('home') }}" class="text-[#0d9488] hover:text-[#0f766e] text-sm font-medium focus:outline-none focus:underline">
        &laquo; Kembali ke Beranda
    </a>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="md:flex">
        <div class="md:flex-shrink-0 md:w-1/3">
            @if(isset($lapangan) && $lapangan->foto)
                <img class="h-64 w-full object-cover md:h-full" src="{{ asset('storage/' . $lapangan->foto) }}" alt="Foto {{ $lapangan->nama }}">
            @else
                <div class="h-64 w-full bg-gray-200 flex items-center justify-center text-gray-400 md:h-full">
                    Tidak ada foto
                </div>
            @endif
        </div>
        <div class="p-8 w-full">
            <div class="flex justify-between items-start">
                <div>
                    <div class="uppercase tracking-wide text-sm text-[#0d9488] font-bold">{{ isset($lapangan) ? ucfirst($lapangan->tipe) : 'Tipe' }}</div>
                    <h1 class="mt-1 text-3xl font-extrabold text-[#1e3a5f]">{{ $lapangan->nama ?? 'Nama Lapangan' }}</h1>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-[#1a1a1a]">Rp {{ isset($lapangan) ? number_format($lapangan->harga_per_jam, 0, ',', '.') : '0' }}</div>
                    <div class="text-sm text-[#64748b]">per jam</div>
                </div>
            </div>
            
            <div class="mt-4">
                <h3 class="text-lg font-medium text-[#1a1a1a]">Deskripsi</h3>
                <p class="mt-2 text-[#64748b]">{{ $lapangan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
            
            <div class="mt-4">
                <h3 class="text-lg font-medium text-[#1a1a1a]">Alamat</h3>
                <p class="mt-2 text-[#64748b]">{{ $lapangan->alamat ?? 'Tidak ada alamat' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4">Cek Ketersediaan Jadwal</h2>
    
    <form action="{{ isset($lapangan) ? route('lapangan.show', $lapangan->id) : '#' }}" method="GET" class="mb-6 flex gap-4 items-end">
        <div>
            <label for="tanggal" class="block text-sm font-medium text-[#1a1a1a]">Pilih Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] sm:text-sm">
        </div>
        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#1e3a5f] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
                Cek Jadwal
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#64748b] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($jadwal_slots) && count($jadwal_slots) > 0)
                    @foreach($jadwal_slots as $slot)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($slot->tersedia)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Sudah Dipesan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($slot->tersedia)
                                    <form action="{{ route('booking.create') ?? '#' }}" method="GET">
                                        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                        <button type="submit" class="text-white bg-[#0d9488] hover:bg-[#0f766e] px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                                            Booking Sekarang
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="text-gray-400 bg-gray-100 px-3 py-1 rounded cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-[#64748b]">
                            Tidak ada jadwal tersedia untuk tanggal ini.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
