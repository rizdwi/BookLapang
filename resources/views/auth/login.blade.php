@extends('layouts.guest')

@section('content')
<form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
    @csrf
    
    <div class="rounded-md shadow-sm space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-[#1a1a1a]">Alamat Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="email@contoh.com" value="{{ old('email') }}">
            @error('email')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-[#1a1a1a]">Kata Sandi</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#0d9488] focus:border-[#0d9488] focus:z-10 sm:text-sm mt-1" placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-sm text-[#dc2626]">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-[#0d9488] focus:ring-[#0d9488] border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-[#1a1a1a]">
                Ingat saya
            </label>
        </div>
    </div>

    <div>
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
            Masuk
        </button>
    </div>
    
    <div class="text-sm text-center">
        <a href="{{ route('register') }}" class="font-medium text-[#0d9488] hover:text-[#0f766e]">
            Belum punya akun? Daftar di sini
        </a>
    </div>
</form>
@endsection
