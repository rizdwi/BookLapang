@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.lapangan.index') ?? '#' }}" class="text-[#0d9488] hover:text-[#0f766e] text-sm font-medium focus:outline-none focus:underline">
        &laquo; Kembali ke Daftar Lapangan
    </a>
</div>

<div class="bg-[#ffffff] rounded-lg shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-[#1a1a1a]">
            Edit Lapangan: {{ $lapangan->nama ?? 'Nama Lapangan' }}
        </h3>
    </div>
    
    <form action="{{ isset($lapangan) ? route('admin.lapangan.update', $lapangan->id) : '#' }}" method="POST" enctype="multipart/form-data" class="px-6 py-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="nama" class="block text-sm font-medium text-[#1a1a1a]">Nama Lapangan</label>
                <div class="mt-1">
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $lapangan->nama ?? '') }}" required class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">
                </div>
                @error('nama')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="tipe" class="block text-sm font-medium text-[#1a1a1a]">Tipe Lapangan</label>
                <div class="mt-1">
                    <select id="tipe" name="tipe" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2 bg-white">
                        <option value="futsal" {{ old('tipe', $lapangan->tipe ?? '') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="badminton" {{ old('tipe', $lapangan->tipe ?? '') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="basket" {{ old('tipe', $lapangan->tipe ?? '') == 'basket' ? 'selected' : '' }}>Basket</option>
                        <option value="voli" {{ old('tipe', $lapangan->tipe ?? '') == 'voli' ? 'selected' : '' }}>Voli</option>
                        <option value="tenis" {{ old('tipe', $lapangan->tipe ?? '') == 'tenis' ? 'selected' : '' }}>Tenis</option>
                    </select>
                </div>
                @error('tipe')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-6">
                <label for="deskripsi" class="block text-sm font-medium text-[#1a1a1a]">Deskripsi</label>
                <div class="mt-1">
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">{{ old('deskripsi', $lapangan->deskripsi ?? '') }}</textarea>
                </div>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="harga_per_jam" class="block text-sm font-medium text-[#1a1a1a]">Harga per Jam (Rp)</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" name="harga_per_jam" id="harga_per_jam" value="{{ old('harga_per_jam', $lapangan->harga_per_jam ?? '') }}" required min="0" step="1000" class="focus:ring-[#0d9488] focus:border-[#0d9488] block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md border py-2">
                </div>
                @error('harga_per_jam')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="aktif" class="block text-sm font-medium text-[#1a1a1a]">Status</label>
                <div class="mt-1 flex items-center h-10">
                    <input type="hidden" name="aktif" value="0">
                    <input id="aktif" name="aktif" type="checkbox" value="1" {{ old('aktif', $lapangan->aktif ?? 1) ? 'checked' : '' }} class="focus:ring-[#0d9488] h-4 w-4 text-[#0d9488] border-gray-300 rounded">
                    <label for="aktif" class="ml-2 block text-sm text-[#1a1a1a]">
                        Aktif (Bisa disewa)
                    </label>
                </div>
            </div>

            <div class="sm:col-span-6">
                <label for="alamat" class="block text-sm font-medium text-[#1a1a1a]">Alamat Lapangan</label>
                <div class="mt-1">
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $lapangan->alamat ?? '') }}" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">
                </div>
                @error('alamat')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-6">
                <label class="block text-sm font-medium text-[#1a1a1a]">Foto Lapangan Saat Ini</label>
                <div class="mt-2 mb-4">
                    @if(isset($lapangan) && $lapangan->foto)
                        <img src="{{ asset('storage/' . $lapangan->foto) }}" alt="Foto" class="h-48 rounded object-cover">
                    @else
                        <div class="text-sm text-gray-500">Tidak ada foto</div>
                    @endif
                </div>

                <label for="foto" class="block text-sm font-medium text-[#1a1a1a]">Ganti Foto (Biarkan kosong jika tidak ingin mengubah)</label>
                <div class="mt-1 flex items-center">
                    <input id="foto" name="foto" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-[#f8fafc] file:text-[#0d9488] hover:file:bg-gray-100" accept="image/*">
                </div>
                @error('foto')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-200">
            <div class="flex justify-end">
                <a href="{{ route('admin.lapangan.index') ?? '#' }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-[#1a1a1a] hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e3a5f]">
                    Batal
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                    Perbarui Lapangan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
