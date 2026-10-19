<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Berita') - {{ config('app.name', 'Berita App') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen">

{{-- Navbar --}}
<header class="bg-white border-b border-slate-200 sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-lg bg-slate-900 text-white grid place-items-center font-bold">B</span>
                <span class="font-semibold text-slate-900 text-lg hidden sm:block">Berita App</span>
            </a>
            <nav class="flex items-center gap-1 text-[15px]">
                @php
                    $links = [
                        ['Dashboard', 'dashboard', 'dashboard'],
                        ['Berita', 'berita.index', 'berita.*'],
                        ['Kategori', 'kategori.index', 'kategori.*'],
                    ];
                @endphp
                @foreach ($links as [$label, $route, $pattern])
                    <a href="{{ route($route) }}"
                       class="px-3.5 py-2 rounded-lg font-medium transition
                       {{ request()->routeIs($pattern) ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right hidden md:block leading-tight">
                <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-700 grid place-items-center text-sm font-semibold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-slate-500 hover:text-slate-900 font-medium px-2 py-1.5 rounded-md hover:bg-slate-100">Keluar</button>
            </form>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
