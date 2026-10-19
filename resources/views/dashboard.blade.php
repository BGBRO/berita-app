@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    @php
        $maxKategori = max(1, $perKategori->max('beritas_count'));
        $stats = [
            ['Total berita', $totalBerita],
            ['Berita bulan ini', $bulanIni],
            ['Berita saya', $beritaSaya],
            ['Kategori', $totalKategori],
        ];
    @endphp

    {{-- Sapaan + aksi cepat --}}
    <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Halo, {{ Auth::user()->name }}</h1>
            <p class="text-slate-500 mt-1">Ringkasan berita dan kategori hari ini, {{ now()->translatedFormat('l, d F Y') }}.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('kategori.index') }}"
               class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">Kelola kategori</a>
            <a href="{{ route('berita.create') }}"
               class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 4a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V5a1 1 0 011-1z"/></svg>
                Tulis berita
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ($stats as [$label, $value])
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <div class="text-sm text-slate-500">{{ $label }}</div>
                <div class="text-3xl font-bold text-slate-900 mt-1 tabular-nums">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Berita terbaru --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-slate-900">Berita terbaru</h2>
                <a href="{{ route('berita.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Lihat semua</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($terbaru as $b)
                    <li>
                        <a href="{{ route('berita.edit', $b) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/70">
                            @if ($b->gambar)
                                <img src="{{ asset('storage/'.$b->gambar) }}" alt=""
                                     class="w-20 h-14 rounded-lg object-cover bg-slate-100 shrink-0 ring-1 ring-slate-200">
                            @else
                                <div class="w-20 h-14 rounded-lg bg-slate-100 shrink-0 ring-1 ring-slate-200"></div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="font-semibold text-slate-900 truncate">{{ $b->judul }}</div>
                                <div class="text-sm text-slate-500 mt-0.5">
                                    {{ $b->user->name }} &middot; {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}
                                </div>
                            </div>
                            <span class="hidden sm:inline-flex px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium">{{ $b->kategori->nama }}</span>
                        </a>
                    </li>
                @empty
                    <li class="px-5 py-14 text-center">
                        <div class="font-semibold text-slate-900">Belum ada berita</div>
                        <p class="text-slate-500 mt-1">Tulis berita pertama untuk mulai mengisi dashboard.</p>
                        <a href="{{ route('berita.create') }}" class="inline-flex items-center h-10 px-4 mt-4 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800">Tulis berita</a>
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- Berita per kategori --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="px-5 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-slate-900">Berita per kategori</h2>
            </div>
            <div class="p-5 space-y-4">
                @forelse ($perKategori as $k)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="font-medium text-slate-700">{{ $k->nama }}</span>
                            <span class="text-slate-500 tabular-nums">{{ $k->beritas_count }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-slate-800" style="width: {{ ($k->beritas_count / $maxKategori) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada kategori. <a href="{{ route('kategori.index') }}" class="font-medium text-slate-900 underline">Tambah kategori</a></p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
