@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#1e3a5f]">Generate Jadwal Lapangan</h1>
    <p class="text-[#64748b]">Buat slot waktu ketersediaan untuk disewa.</p>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('admin.jadwal.store') ?? '#' }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-4 items-end">
            <div class="sm:col-span-1">
                <label for="lapangan_id" class="block text-sm font-medium text-[#1a1a1a]">Pilih Lapangan</label>
                <select id="lapangan_id" name="lapangan_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] sm:text-sm rounded-md border">
                    <option value="">Pilih Lapangan...</option>
                    @if(isset($lapangan))
                        @foreach($lapangan as $lap)
                            <option value="{{ $lap->id }}">{{ $lap->nama }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="sm:col-span-1">
                <label for="tanggal_mulai" class="block text-sm font-medium text-[#1a1a1a]">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] sm:text-sm">
            </div>

            <div class="sm:col-span-1">
                <label for="tanggal_selesai" class="block text-sm font-medium text-[#1a1a1a]">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] sm:text-sm">
            </div>

            <div class="sm:col-span-1">
                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                    Generate Jadwal
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-[#1a1a1a]">
            Jadwal yang Tersedia (Hari Ini)
        </h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Lapangan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Waktu</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#64748b] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($jadwal) && count($jadwal) > 0)
                    @foreach($jadwal as $slot)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-[#1a1a1a]">{{ $slot->lapangan->nama ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                {{ \Carbon\Carbon::parse($slot->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($slot->tersedia)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Terpesan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.jadwal.toggle', $slot->id) ?? '#' }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if($slot->tersedia)
                                        <button type="submit" class="text-[#dc2626] hover:text-red-900 focus:outline-none">Tutup Slot</button>
                                    @else
                                        <button type="submit" class="text-green-600 hover:text-green-900 focus:outline-none">Buka Slot</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-[#64748b]">
                            Belum ada jadwal untuk hari ini. Silakan generate jadwal.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
