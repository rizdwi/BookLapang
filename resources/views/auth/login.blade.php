@extends('layouts.guest')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black tracking-tight text-white">Selamat Datang</h1>
    <p class="text-xs text-slate-400 mt-1">Masuk untuk mengelola pesanan atau booking lapangan baru.</p>
</div>

<form class="space-y-5" action="{{ route('login') }}" method="POST">
    @csrf
    
    <div class="space-y-4">
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Alamat Email</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   autocomplete="email" 
                   required 
                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
                   placeholder="nama@email.com" 
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-1.5 text-xs font-semibold text-rose-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">Kata Sandi</label>
            </div>
            <input id="password" 
                   name="password" 
                   type="password" 
                   autocomplete="current-password" 
                   required 
                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs font-semibold text-rose-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer select-none">
            <input id="remember_me" 
                   name="remember" 
                   type="checkbox" 
                   class="h-4 w-4 rounded-md bg-slate-900 border-slate-700 text-pitch-600 focus:ring-pitch-500 focus:ring-offset-slate-950">
            <span class="text-xs font-medium text-slate-400">Ingat saya di perangkat ini</span>
        </label>
    </div>

    <div>
        <button type="submit" 
                class="w-full py-3 px-4 rounded-xl text-sm font-extrabold text-white bg-pitch-600 hover:bg-pitch-500 shadow-lg shadow-pitch-600/30 transition-all transform hover:-translate-y-0.5 focus:outline-hidden focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950 cursor-pointer">
            Masuk ke Akun
        </button>
    </div>
    
    <div class="text-xs text-center text-slate-400 pt-2 border-t border-slate-800/80">
        Belum memiliki akun? 
        <a href="{{ route('register') }}" class="font-bold text-emerald-400 hover:text-emerald-300 ml-1 transition-colors">
            Daftar sekarang
        </a>
    </div>
</form>
@endsection
