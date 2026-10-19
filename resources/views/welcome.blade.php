<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Berita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } } }</script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-sm p-10 text-center">
        <span class="w-12 h-12 rounded-xl bg-slate-900 text-white grid place-items-center text-xl font-bold mx-auto mb-6">B</span>
        <h1 class="text-2xl font-bold text-slate-900">Portal Berita</h1>
        <p class="text-slate-500 mt-2 mb-8">Kelola berita dan kategori dalam satu tempat.</p>

        @auth
            <p class="text-slate-600 mb-4">Halo, {{ Auth::user()->name }}</p>
            <a href="{{ route('dashboard') }}"
               class="flex items-center justify-center h-11 rounded-lg bg-slate-900 text-white font-medium hover:bg-slate-800 mb-3">Buka dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full h-11 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Keluar</button>
            </form>
        @else
            <div class="space-y-3">
                <a href="{{ route('login') }}"
                   class="flex items-center justify-center h-11 rounded-lg bg-slate-900 text-white font-medium hover:bg-slate-800">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center h-11 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50">Buat akun baru</a>
                @endif
            </div>
        @endauth
    </div>
</body>
</html>
