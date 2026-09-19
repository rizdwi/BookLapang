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
            Tambah Lapangan Baru
        </h3>
    </div>
    
    <form action="{{ route('admin.lapangan.store') ?? '#' }}" method="POST" enctype="multipart/form-data" class="px-6 py-6">
        @csrf
        
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <label for="nama" class="block text-sm font-medium text-[#1a1a1a]">Nama Lapangan</label>
                <div class="mt-1">
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">
                </div>
                @error('nama')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="tipe" class="block text-sm font-medium text-[#1a1a1a]">Tipe Lapangan</label>
                <div class="mt-1">
                    <select id="tipe" name="tipe" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2 bg-white">
                        <option value="futsal" {{ old('tipe') == 'futsal' ? 'selected' : '' }}>Futsal</option>
                        <option value="badminton" {{ old('tipe') == 'badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="basket" {{ old('tipe') == 'basket' ? 'selected' : '' }}>Basket</option>
                        <option value="voli" {{ old('tipe') == 'voli' ? 'selected' : '' }}>Voli</option>
                        <option value="tenis" {{ old('tipe') == 'tenis' ? 'selected' : '' }}>Tenis</option>
                    </select>
                </div>
                @error('tipe')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-6">
                <label for="deskripsi" class="block text-sm font-medium text-[#1a1a1a]">Deskripsi</label>
                <div class="mt-1">
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">{{ old('deskripsi') }}</textarea>
                </div>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="harga_per_jam" class="block text-sm font-medium text-[#1a1a1a]">Harga per Jam (Rp)</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" name="harga_per_jam" id="harga_per_jam" value="{{ old('harga_per_jam') }}" required min="0" step="1000" class="focus:ring-[#0d9488] focus:border-[#0d9488] block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md border py-2">
                </div>
                @error('harga_per_jam')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="aktif" class="block text-sm font-medium text-[#1a1a1a]">Status</label>
                <div class="mt-1 flex items-center h-10">
                    <input type="hidden" name="aktif" value="0">
                    <input id="aktif" name="aktif" type="checkbox" value="1" {{ old('aktif', 1) ? 'checked' : '' }} class="focus:ring-[#0d9488] h-4 w-4 text-[#0d9488] border-gray-300 rounded">
                    <label for="aktif" class="ml-2 block text-sm text-[#1a1a1a]">
                        Aktif (Bisa disewa)
                    </label>
                </div>
            </div>

            <div class="sm:col-span-6">
                <label for="alamat" class="block text-sm font-medium text-[#1a1a1a]">Alamat Lapangan</label>
                <div class="mt-1">
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488] block w-full sm:text-sm border-gray-300 rounded-md border px-3 py-2">
                </div>
                @error('alamat')
                    <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-6">
                <label for="foto" class="block text-sm font-medium text-[#1a1a1a]">Foto Lapangan</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-gray-50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-[#0d9488] hover:text-[#0f766e] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#0d9488] px-2 py-1">
                                <span>Unggah file</span>
                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                    </div>
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
                    Simpan Lapangan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
