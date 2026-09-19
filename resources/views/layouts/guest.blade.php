<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - BookLapang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-[#1a1a1a] min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-[#ffffff] p-8 rounded-lg shadow-sm border border-gray-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-[#1e3a5f]">
                BookLapang
            </h2>
            <p class="mt-2 text-center text-sm text-[#64748b]">
                Akses akun Anda untuk mulai memesan
            </p>
        </div>
        
        <x-flash-message />
        
        @yield('content')
    </div>
</body>
</html>
