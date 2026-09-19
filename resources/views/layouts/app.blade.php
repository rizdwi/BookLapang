<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLapang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#1a1a1a] min-h-screen flex flex-col">
    <nav class="bg-[#1e3a5f] text-white" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') ?? '/' }}" class="font-bold text-xl tracking-tight hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#1e3a5f] rounded px-2 py-1">BookLapang</a>
                </div>
                
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('home') ?? '/' }}" class="px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Beranda</a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') ?? '/admin' }}" class="px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Dasbor Admin</a>
                        @else
                            <a href="{{ route('customer.dashboard') ?? '/dashboard' }}" class="px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Dasbor</a>
                        @endif
                        <form method="POST" action="{{ route('logout') ?? '/logout' }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-md hover:bg-[#dc2626] focus:outline-none focus:ring-2 focus:ring-white">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') ?? '/login' }}" class="px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Masuk</a>
                        <a href="{{ route('register') ?? '/register' }}" class="px-3 py-2 rounded-md bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-white">Daftar</a>
                    @endauth
                </div>

                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" class="sm:hidden" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') ?? '/' }}" class="block px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Beranda</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') ?? '/admin' }}" class="block px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Dasbor Admin</a>
                    @else
                        <a href="{{ route('customer.dashboard') ?? '/dashboard' }}" class="block px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Dasbor</a>
                    @endif
                    <form method="POST" action="{{ route('logout') ?? '/logout' }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md hover:bg-[#dc2626] focus:outline-none focus:ring-2 focus:ring-white">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') ?? '/login' }}" class="block px-3 py-2 rounded-md hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-white">Masuk</a>
                    <a href="{{ route('register') ?? '/register' }}" class="block px-3 py-2 rounded-md bg-[#0d9488] hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-white mt-1">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <x-flash-message />
        @yield('content')
    </main>

    <footer class="bg-[#1e3a5f] text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-300">
            &copy; {{ date('Y') }} BookLapang. Hak Cipta Dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
