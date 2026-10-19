@extends('layouts.admin')

@section('title', $berita->judul)

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Navigasi atas --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('berita.index') }}"
               class="text-sm text-slate-500 hover:text-slate-900">&larr; Kembali</a>
            <div class="flex items-center gap-2">
                <a href="{{ route('berita.cetak', $berita) }}" target="_blank"
                   class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a1 1 0 001 1h8a1 1 0 001-1v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a1 1 0 00-1-1H6a1 1 0 00-1 1zm2 0h6v3H7V4zm-1 9h8v4H6v-4z" clip-rule="evenodd"/></svg>
                    Cetak PDF
                </a>
                <a href="{{ route('berita.edit', $berita) }}"
                   class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">Edit berita</a>
                <form action="{{ route('berita.destroy', $berita) }}" method="POST"
                      onsubmit="return confirm('Hapus berita ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center h-10 px-4 rounded-lg border border-red-200 bg-white text-sm font-medium text-red-600 hover:bg-red-50">Hapus</button>
                </form>
            </div>
        </div>

        <article class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            @if ($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}"
                     class="w-full max-h-[480px] object-cover bg-slate-100">
            @endif

            <div class="px-6 sm:px-10 py-8">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium">
                    {{ $berita->kategori->nama }}
                </span>

                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mt-4">{{ $berita->judul }}</h1>

                <div class="flex items-center gap-3 mt-5 pb-6 border-b border-slate-200">
                    <span class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 grid place-items-center text-sm font-semibold shrink-0">
                        {{ strtoupper(substr($berita->user->name, 0, 1)) }}
                    </span>
                    <div class="leading-tight">
                        <div class="font-medium text-slate-800">{{ $berita->user->name }}</div>
                        <div class="text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($berita->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Isi berita --}}
                <div class="mt-6 max-w-3xl text-lg text-slate-700 leading-8 whitespace-pre-line">{{ $berita->isi }}</div>
            </div>
        </article>

        {{-- Berita terkait --}}
        @if ($terkait->isNotEmpty())
            <section class="mt-10">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Berita lain di kategori {{ $berita->kategori->nama }}</h2>
                <div class="grid sm:grid-cols-3 gap-4">
                    @foreach ($terkait as $t)
                        <a href="{{ route('berita.show', $t) }}"
                           class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden hover:border-slate-300">
                            @if ($t->gambar)
                                <img src="{{ asset('storage/'.$t->gambar) }}" alt="" class="w-full h-32 object-cover bg-slate-100">
                            @else
                                <div class="w-full h-32 bg-slate-100"></div>
                            @endif
                            <div class="p-4">
                                <div class="font-semibold text-slate-900 line-clamp-2">{{ $t->judul }}</div>
                                <div class="text-sm text-slate-500 mt-1">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
