<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BookLapang') }} - Autentikasi</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
    <style>
        body {
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased relative overflow-hidden">
    {{-- Subtle stadium field grid lines background --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-md w-full relative z-10">
        {{-- Brand Header --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-pitch-600 text-white flex items-center justify-center font-black shadow-lg shadow-pitch-600/30 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="block font-black text-2xl tracking-tight text-white leading-none">BookLapang</span>
                    <span class="text-xs font-semibold text-emerald-400 uppercase tracking-widest mt-1 block">Venue Platform</span>
                </div>
            </a>
        </div>

        {{-- Card Container --}}
        <div class="bg-slate-950/80 backdrop-blur-xl rounded-3xl p-7 sm:p-8 border border-slate-800 shadow-2xl">
            <x-flash-message />
            @yield('content')
        </div>

        <div class="text-center mt-6 text-xs text-slate-500">
            <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors font-semibold">&larr; Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
