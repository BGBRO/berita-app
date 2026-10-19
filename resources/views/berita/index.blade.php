@extends('layouts.admin')

@section('title', 'Daftar Berita')

@section('content')
    {{-- Judul halaman --}}
    <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Berita</h1>
            <p class="text-slate-500 mt-1">Kelola semua berita yang sudah dipublikasikan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('berita.cetak-semua') }}" target="_blank"
               class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">
                Cetak daftar PDF
            </a>
            <a href="{{ route('kategori.index') }}"
               class="inline-flex items-center h-10 px-4 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">
                Kelola kategori
            </a>
            <a href="{{ route('berita.create') }}"
               class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 4a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V5a1 1 0 011-1z"/></svg>
                Tambah berita
            </a>
        </div>
    </div>

    @if (session('success'))
        <div id="flash" class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 text-sm">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('flash').remove()" class="text-emerald-600 hover:text-emerald-900" aria-label="Tutup">&times;</button>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-slate-200">
            <div class="text-sm text-slate-500">
                Total <span class="font-semibold text-slate-900">{{ $beritas->total() }}</span> berita
            </div>
            <div class="relative w-full sm:w-72">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
                <input id="search" type="text" placeholder="Cari judul, kategori, atau penulis"
                       class="w-full h-10 pl-9 pr-3 rounded-lg border border-slate-300 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Berita</th>
                        <th class="px-5 py-3 font-semibold">Kategori</th>
                        <th class="px-5 py-3 font-semibold">Penulis</th>
                        <th class="px-5 py-3 font-semibold whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="rows" class="divide-y divide-slate-100">
                @forelse ($beritas as $b)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                @if ($b->gambar)
                                    <img src="{{ asset('storage/'.$b->gambar) }}" alt=""
                                         class="w-24 h-16 rounded-lg object-cover bg-slate-100 shrink-0 ring-1 ring-slate-200">
                                @else
                                    <div class="w-24 h-16 rounded-lg bg-slate-100 shrink-0 grid place-items-center text-slate-400 ring-1 ring-slate-200">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.16-5.16a2.25 2.25 0 013.18 0l5.16 5.16m-1.5-1.5l1.41-1.41a2.25 2.25 0 013.18 0l2.41 2.41M3.75 21h16.5A1.5 1.5 0 0021.75 19.5v-15A1.5 1.5 0 0020.25 3H3.75A1.5 1.5 0 002.25 4.5v15A1.5 1.5 0 003.75 21zM9 8.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('berita.show', $b) }}" class="block font-semibold text-slate-900 text-[15px] truncate max-w-xs hover:underline">{{ $b->judul }}</a>
                                    <div class="text-slate-500 mt-0.5 line-clamp-1 max-w-xs">{{ \Illuminate\Support\Str::limit(strip_tags($b->isi), 70) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium">
                                {{ $b->kategori->nama }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 grid place-items-center text-xs font-semibold shrink-0">
                                    {{ strtoupper(substr($b->user->name ?? $b->user->email, 0, 1)) }}
                                </span>
                                <div class="leading-tight">
                                    <div class="font-medium text-slate-800">{{ $b->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $b->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-slate-600">
                            {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-0.5 whitespace-nowrap">
                                <a href="{{ route('berita.cetak', $b) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 h-9 px-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a1 1 0 001 1h8a1 1 0 001-1v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a1 1 0 00-1-1H6a1 1 0 00-1 1zm2 0h6v3H7V4zm-1 9h8v4H6v-4z" clip-rule="evenodd"/></svg>
                                    Cetak
                                </a>
                                <a href="{{ route('berita.show', $b) }}"
                                   class="inline-flex items-center gap-1.5 h-9 px-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Lihat
                                </a>
                                <a href="{{ route('berita.edit', $b) }}"
                                   class="inline-flex items-center gap-1.5 h-9 px-2.5 rounded-lg text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium">
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('berita.destroy', $b) }}" method="POST"
                                      onsubmit="return confirm('Hapus berita &quot;{{ addslashes($b->judul) }}&quot;? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button class="inline-flex items-center gap-1.5 h-9 px-2.5 rounded-lg text-red-600 hover:bg-red-50 font-medium">
                                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="text-slate-900 font-semibold">Belum ada berita</div>
                            <p class="text-slate-500 mt-1">Mulai dengan menulis berita pertama kamu.</p>
                            <a href="{{ route('berita.create') }}" class="inline-flex items-center h-10 px-4 mt-4 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800">Tambah berita</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div id="no-result" class="hidden px-5 py-12 text-center text-slate-500">Tidak ada berita yang cocok dengan pencarian.</div>

        {{-- Pagination --}}
        @if ($beritas->hasPages())
            <div class="px-5 py-4 border-t border-slate-200">{{ $beritas->links() }}</div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Pencarian cepat pada baris yang tampil di halaman ini
    const input = document.getElementById('search');
    const rows = document.querySelectorAll('#rows tr');
    const empty = document.getElementById('no-result');
    input?.addEventListener('input', () => {
        const q = input.value.trim().toLowerCase();
        let shown = 0;
        rows.forEach(r => {
            const match = r.textContent.toLowerCase().includes(q);
            r.classList.toggle('hidden', !match);
            if (match) shown++;
        });
        empty.classList.toggle('hidden', shown > 0 || rows.length === 0);
    });
</script>
@endpush