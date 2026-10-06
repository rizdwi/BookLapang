<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BookLapang') }} - Sistem Reservasi Lapangan Olahraga</title>
    
    {{-- Google Fonts: Outfit & JetBrains Mono --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Outfit"', 'system-ui', '-apple-system', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        navy: {
                            800: '#162238',
                            900: '#0d1526',
                            950: '#070b14',
                        },
                        pitch: {
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col antialiased selection:bg-slate-900 selection:text-emerald-400">

    {{-- TOPBAR BRANDED NAVIGATION --}}
    <header class="sticky top-0 z-50 bg-navy-950/95 backdrop-blur-md border-b border-slate-800/80 text-white" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                
                {{-- Logo & Brandmark --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-hidden">
                        <div class="w-10 h-10 rounded-xl bg-pitch-600 text-white flex items-center justify-center font-black tracking-tight shadow-md shadow-pitch-600/30 group-hover:bg-pitch-500 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <line x1="3" y1="12" x2="21" y2="12"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl tracking-tight text-white group-hover:text-emerald-400 transition-colors leading-none">
                                BookLapang
                            </span>
                            <span class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase mt-1">
                                Venue Reservation
                            </span>
                        </div>
                    </a>

                    {{-- Desktop Primary Nav --}}
                    <nav class="hidden md:flex items-center space-x-1" aria-label="Main Navigation">
                        <a href="{{ route('home') }}" 
                           class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('home') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            Beranda
                        </a>
                        <a href="{{ route('lapangan.index') }}" 
                           class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('lapangan.*') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            Pesan Lapangan
                        </a>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="h-4 w-px bg-slate-800 mx-2"></div>
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Dasbor
                                </a>
                                <a href="{{ route('admin.timetable') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.timetable') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Kalender Kasir
                                </a>
                                <a href="{{ route('admin.checkin.view') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.checkin.*') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Check-In
                                </a>
                                <a href="{{ route('admin.lapangan.index') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.lapangan.*') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Lapangan
                                </a>
                                <a href="{{ route('admin.jadwal.index') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.jadwal.*') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Jadwal
                                </a>
                                <a href="{{ route('admin.booking.index') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('admin.booking.*') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Pesanan
                                </a>
                            @else
                                <div class="h-4 w-px bg-slate-800 mx-2"></div>
                                <a href="{{ route('customer.dashboard') }}" 
                                   class="px-3.5 py-2 rounded-xl text-xs uppercase tracking-wider font-bold transition-all {{ request()->routeIs('customer.dashboard') ? 'bg-white/10 text-emerald-400 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    Pesanan Saya
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>

                {{-- User Profile & CTA / Auth Actions --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3 bg-slate-900/90 border border-slate-800 px-3.5 py-1.5 rounded-2xl">
                            <div class="w-8 h-8 rounded-xl bg-slate-800 flex items-center justify-center text-xs font-bold text-white border border-slate-700">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-bold text-white leading-tight">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->isAdmin())
                                    <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest leading-none mt-0.5">Admin Venue</span>
                                @else
                                    <span class="text-[10px] font-semibold text-emerald-400 uppercase tracking-widest leading-none mt-0.5">Pemain</span>
                                @endif
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-3.5 py-2 rounded-xl text-xs font-bold text-rose-300 hover:text-white hover:bg-rose-950/40 border border-transparent hover:border-rose-900/50 transition-all cursor-pointer">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2.5 rounded-xl text-xs uppercase tracking-wider font-bold text-slate-200 hover:text-white hover:bg-white/5 transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider font-extrabold text-white bg-pitch-600 hover:bg-pitch-500 shadow-md shadow-pitch-600/30 transition-all transform hover:-translate-y-0.5">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                {{-- Mobile Hamburger Button --}}
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button"
                            class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 focus:outline-hidden" 
                            aria-expanded="false">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Mobile Drawer Menu --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden border-t border-slate-800 bg-navy-950 px-4 pt-3 pb-6 space-y-1" 
             style="display: none;">
            <a href="{{ route('home') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Beranda</a>
            <a href="{{ route('lapangan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Pesan Lapangan</a>
            
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="pt-2 pb-1 text-[11px] font-black uppercase tracking-wider text-amber-400 px-3.5">Menu Admin</div>
                    <a href="{{ route('admin.dashboard') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Dasbor</a>
                    <a href="{{ route('admin.timetable') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Kalender Kasir</a>
                    <a href="{{ route('admin.checkin.view') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Check-In Scanner</a>
                    <a href="{{ route('admin.lapangan.index') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Kelola Lapangan</a>
                    <a href="{{ route('admin.jadwal.index') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Kelola Jadwal</a>
                    <a href="{{ route('admin.booking.index') }}" class="block px-3.5 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/5">Data Pesanan</a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Pesanan Saya</a>
                @endif
                <div class="pt-4 mt-2 border-t border-slate-800 flex items-center justify-between px-3">
                    <span class="text-xs font-bold text-slate-300">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-rose-400 hover:text-rose-300">Keluar</button>
                    </form>
                </div>
            @else
                <div class="pt-4 border-t border-slate-800 flex gap-2">
                    <a href="{{ route('login') }}" class="w-1/2 text-center py-2.5 rounded-xl text-sm font-bold bg-white/10 text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="w-1/2 text-center py-2.5 rounded-xl text-sm font-bold bg-pitch-600 text-white">Daftar</a>
                </div>
            @endauth
        </div>
    </header>

    {{-- MAIN CONTENT AREA --}}
    @hasSection('full_width')
        <main class="flex-grow w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <x-flash-message />
            </div>
            @yield('content')
        </main>
    @else
        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            <x-flash-message />
            @yield('content')
        </main>
    @endif

    {{-- HIGH-CRAFT FOOTER --}}
    <footer class="bg-navy-950 text-white border-t border-slate-800/80 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-pitch-600 text-white flex items-center justify-center font-black">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <line x1="3" y1="12" x2="21" y2="12"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white">BookLapang</span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                        Platform reservasi lapangan olahraga instan dan terintegrasi. Bebas bentrok jadwal, konfirmasi slot instan, dan pembayaran otomatis via QRIS & Virtual Account.
                    </p>
                    <div class="flex items-center gap-4 text-xs font-semibold text-emerald-400">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Sistem Siap Operasional
                        </span>
                        <span>&bull;</span>
                        <span>Garansi Anti Double-Booking</span>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-sm text-slate-300">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('lapangan.index') }}" class="hover:text-emerald-400 transition-colors">Katalog & Jadwal</a></li>
                        <li><a href="{{ route('lapangan.index', ['tipe' => 'futsal']) }}" class="hover:text-emerald-400 transition-colors">Lapangan Futsal</a></li>
                        <li><a href="{{ route('lapangan.index', ['tipe' => 'badminton']) }}" class="hover:text-emerald-400 transition-colors">Lapangan Badminton</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Metode Bayar Resmi</h4>
                    <ul class="space-y-2.5 text-sm text-slate-300">
                        <li class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-[11px] font-mono font-bold text-slate-200">QRIS</span>
                            <span>E-Wallet & Bank Apapun</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-[11px] font-mono font-bold text-slate-200">VA</span>
                            <span>BCA Virtual Account</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-[11px] font-mono font-bold text-slate-200">CASH</span>
                            <span>Kasir di Lokasi Venue</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} BookLapang. Didesain dengan presisi dan performa tinggi.</p>
                <p>Arsitektur Zero-Bentrok &bull; Konfirmasi Real-Time</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
