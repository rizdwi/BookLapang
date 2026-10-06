@extends('layouts.guest')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black tracking-tight text-white">Daftar Akun Baru</h1>
    <p class="text-xs text-slate-400 mt-1">Buat akun untuk memesan lapangan dan simpan riwayat booking.</p>
</div>

<form class="space-y-4" action="{{ route('register') }}" method="POST">
    @csrf
    
    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Nama Lengkap</label>
        <input id="name" 
               name="name" 
               type="text" 
               autocomplete="name" 
               required 
               class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
               placeholder="Nama Anda" 
               value="{{ old('name') }}">
        @error('name')
            <p class="mt-1.5 text-xs font-semibold text-rose-400">{{ $message }}</p>
        @enderror
    </div>

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
        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Nomor WhatsApp / HP</label>
        <input id="phone" 
               name="phone" 
               type="text" 
               autocomplete="tel" 
               required 
               class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
               placeholder="081234567890" 
               value="{{ old('phone') }}">
        @error('phone')
            <p class="mt-1.5 text-xs font-semibold text-rose-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Kata Sandi</label>
            <input id="password" 
                   name="password" 
                   type="password" 
                   required 
                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
                   placeholder="Min 8 karakter">
            @error('password')
                <p class="mt-1.5 text-xs font-semibold text-rose-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Konfirmasi</label>
            <input id="password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   required 
                   class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-hidden focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors shadow-xs" 
                   placeholder="Ulangi sandi">
        </div>
    </div>

    <div class="pt-2">
        <button type="submit" 
                class="w-full py-3 px-4 rounded-xl text-sm font-extrabold text-white bg-pitch-600 hover:bg-pitch-500 shadow-lg shadow-pitch-600/30 transition-all transform hover:-translate-y-0.5 focus:outline-hidden focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-slate-950 cursor-pointer">
            Buat Akun Sekarang
        </button>
    </div>
    
    <div class="text-xs text-center text-slate-400 pt-2 border-t border-slate-800/80">
        Sudah memiliki akun? 
        <a href="{{ route('login') }}" class="font-bold text-emerald-400 hover:text-emerald-300 ml-1 transition-colors">
            Masuk di sini
        </a>
    </div>
</form>
@endsection
