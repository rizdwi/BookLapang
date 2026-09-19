<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BookLapang') }} - Sistem Reservasi Lapangan Olahraga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#1a1a1a] min-h-screen flex flex-col">
    <nav class="bg-[#1e3a5f] text-white shadow" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="font-black text-2xl tracking-tight text-white hover:text-teal-200 transition-colors flex items-center gap-2">
                        <span class="bg-[#0d9488] px-2 py-0.5 rounded text-white text-base font-extrabold tracking-normal">BL</span>
                        BookLapang
                    </a>
                    
                    <div class="hidden md:flex md:items-center md:space-x-1">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('home') ? 'bg-white/15 text-teal-300' : '' }}">
                            Cari Lapangan
                        </a>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-teal-300' : '' }}">
                                    Dasbor Admin
                                </a>
                                <a href="{{ route('admin.lapangan.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('admin.lapangan.*') ? 'bg-white/15 text-teal-300' : '' }}">
                                    Kelola Lapangan
                                </a>
                                <a href="{{ route('admin.jadwal.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('admin.jadwal.*') ? 'bg-white/15 text-teal-300' : '' }}">
                                    Kelola Jadwal
                                </a>
                                <a href="{{ route('admin.booking.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('admin.booking.*') ? 'bg-white/15 text-teal-300' : '' }}">
                                    Data Pesanan
                                </a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 {{ request()->routeIs('customer.dashboard') ? 'bg-white/15 text-teal-300' : '' }}">
                                    Dasbor & Pesanan Saya
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="hidden md:flex md:items-center md:space-x-3">
                    @auth
                        <div class="flex items-center gap-2 border-r border-white/20 pr-4 mr-1 text-sm">
                            <span class="font-semibold text-white">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="bg-amber-400 text-amber-950 font-bold px-2 py-0.5 rounded text-xs uppercase tracking-wider">Admin</span>
                            @else
                                <span class="bg-teal-500 text-white font-medium px-2 py-0.5 rounded text-xs">Pelanggan</span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-red-600/90 hover:bg-red-700 text-white transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 text-white">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-semibold bg-[#0d9488] hover:bg-[#0f766e] text-white shadow-sm transition-colors">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md hover:bg-white/10 text-white focus:outline-none" aria-expanded="false">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" class="md:hidden border-t border-white/10" style="display: none;">
            <div class="px-3 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Cari Lapangan</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Dasbor Admin</a>
                        <a href="{{ route('admin.lapangan.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Kelola Lapangan</a>
                        <a href="{{ route('admin.jadwal.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Kelola Jadwal</a>
                        <a href="{{ route('admin.booking.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Data Pesanan</a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Dasbor & Pesanan Saya</a>
                    @endif
                    <div class="pt-3 border-t border-white/10 flex justify-between items-center px-3">
                        <span class="text-sm font-semibold">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs bg-red-600 px-3 py-1 rounded text-white font-medium">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-sm font-medium bg-[#0d9488] text-white">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <x-flash-message />
        @yield('content')
    </main>

    <footer class="bg-[#1e3a5f] text-white py-8 mt-auto border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-300">
            <div>
                <span class="font-bold text-white tracking-wide">BookLapang</span> &bull; Platform Booking Olahraga Terintegrasi
            </div>
            <div class="text-xs text-gray-400">
                &copy; {{ date('Y') }} Rizki Dwi Sandy. Didesain untuk performa dan keandalan sistem.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
