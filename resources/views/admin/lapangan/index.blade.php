@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-[#1e3a5f]">Kelola Lapangan</h1>
        <p class="text-[#64748b]">Daftar semua lapangan yang tersedia di sistem.</p>
    </div>
    <div>
        <a href="{{ route('admin.lapangan.create') ?? '#' }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
            + Tambah Lapangan
        </a>
    </div>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#f8fafc]">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Nama Lapangan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Tipe</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Harga / Jam</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#64748b] uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#64748b] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($lapangan) && count($lapangan) > 0)
                    @foreach($lapangan as $lap)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded overflow-hidden">
                                        @if($lap->foto)
                                            <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $lap->foto) }}" alt="">
                                        @else
                                            <svg class="h-10 w-10 text-gray-400 p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-[#1a1a1a]">{{ $lap->nama }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($lap->tipe) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#1a1a1a]">
                                Rp {{ number_format($lap->harga_per_jam, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lap->aktif)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.lapangan.edit', $lap->id) ?? '#' }}" class="text-[#0d9488] hover:text-[#0f766e]">Edit</a>
                                    <form action="{{ route('admin.lapangan.destroy', $lap->id) ?? '#' }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#dc2626] hover:text-red-900 focus:outline-none">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-[#64748b]">
                            Belum ada data lapangan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
