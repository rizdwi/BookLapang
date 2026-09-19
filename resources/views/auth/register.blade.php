@extends('layouts.guest')

@section('content')
<form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
    @csrf
    
    <div class="rounded-md shadow-sm space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-[#1a1a1a]">Nama Lengkap</label>
            <input id="name" name="name" type="text" autocomplete="name" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="Nama Anda" value="{{ old('name') }}">
            @error('name')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-[#1a1a1a]">Alamat Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="email@contoh.com" value="{{ old('email') }}">
            @error('email')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-[#1a1a1a]">Nomor HP</label>
            <input id="phone" name="phone" type="text" autocomplete="tel" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
            @error('phone')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-[#1a1a1a]">Kata Sandi</label>
            <input id="password" name="password" type="password" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#1a1a1a]">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="Ketik ulang kata sandi">
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
            Daftar Sekarang
        </button>
    </div>
    
    <div class="text-sm text-center">
        <a href="{{ route('login') }}" class="font-medium text-[#0d9488] hover:text-[#0f766e]">
            Sudah punya akun? Masuk di sini
        </a>
    </div>
</form>
@endsection
