@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Kategori</h1>
        <p class="text-slate-500 mt-1">Kelompokkan berita agar mudah dicari dan dikelola.</p>
    </div>

    @if (session('success'))
        <div id="flash" class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 text-sm">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('flash').remove()" class="text-emerald-600 hover:text-emerald-900" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ $errors->first() }}</div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6 items-start">
        {{-- Tambah kategori --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Tambah kategori</h2>
            <form action="{{ route('kategori.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama kategori</label>
                    <input id="nama" type="text" name="nama" placeholder="Contoh: Olahraga" required
                           class="w-full h-11 px-3.5 rounded-lg border border-slate-300 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
                </div>
                <button class="w-full h-10 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                    Tambah kategori
                </button>
            </form>
        </div>

        {{-- Daftar kategori --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 text-sm text-slate-500">
                Total <span class="font-semibold text-slate-900">{{ $kategoris->count() }}</span> kategori
            </div>

            <ul class="divide-y divide-slate-100">
            @forelse ($kategoris as $k)
                @php $jumlah = $k->beritas_count ?? $k->beritas()->count(); @endphp
                <li class="flex flex-wrap items-center gap-3 px-5 py-3.5">
                    <form action="{{ route('kategori.update', $k) }}" method="POST" class="flex items-center gap-2 flex-1 min-w-[240px]">
                        @csrf @method('PUT')
                        <input type="text" name="nama" value="{{ $k->nama }}" aria-label="Nama kategori"
                               class="flex-1 h-10 px-3 rounded-lg border border-transparent hover:border-slate-300 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 font-medium text-slate-800">
                        <button class="h-9 px-3 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">Simpan</button>
                    </form>

                    <span class="text-sm text-slate-500 tabular-nums whitespace-nowrap">{{ $jumlah }} berita</span>

                    <form action="{{ route('kategori.destroy', $k) }}" method="POST"
                          onsubmit="return confirm('{{ $jumlah > 0 ? 'Hapus kategori ini beserta '.$jumlah.' berita di dalamnya? Tindakan ini tidak bisa dibatalkan.' : 'Hapus kategori ini?' }}')">
                        @csrf @method('DELETE')
                        <button class="h-9 px-3 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">Hapus</button>
                    </form>
                </li>
            @empty
                <li class="px-5 py-14 text-center">
                    <div class="font-semibold text-slate-900">Belum ada kategori</div>
                    <p class="text-slate-500 mt-1">Tambahkan kategori pertama lewat formulir di samping.</p>
                </li>
            @endforelse
            </ul>
        </div>
    </div>
@endsection
