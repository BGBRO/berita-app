@php $b = $berita ?? null; @endphp

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 mb-6 text-sm">
        <div class="font-semibold mb-1">Berita belum bisa disimpan. Periksa lagi:</div>
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($b) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Kolom utama --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
            <div>
                <label for="judul" class="block text-sm font-medium text-slate-700 mb-1.5">Judul</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul', $b->judul ?? '') }}" placeholder="Tulis judul berita"
                       class="w-full h-11 px-3.5 rounded-lg border border-slate-300 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
            </div>
            <div>
                <label for="isi" class="block text-sm font-medium text-slate-700 mb-1.5">Isi berita</label>
                <textarea id="isi" name="isi" rows="14" placeholder="Tulis isi berita di sini"
                          class="w-full px-3.5 py-3 rounded-lg border border-slate-300 placeholder-slate-400 leading-relaxed focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">{{ old('isi', $b->isi ?? '') }}</textarea>
            </div>
        </div>

        {{-- Kolom samping --}}
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-5">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $b->tanggal ?? date('Y-m-d')) }}"
                           class="w-full h-11 px-3.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
                </div>
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                    <select id="kategori_id" name="kategori_id"
                            class="w-full h-11 px-3 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" @selected(old('kategori_id', $b->kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar</label>
                <div class="aspect-video rounded-lg bg-slate-100 ring-1 ring-slate-200 overflow-hidden grid place-items-center mb-3">
                    <img id="preview" class="w-full h-full object-cover {{ ($b && $b->gambar) ? '' : 'hidden' }}"
                         src="{{ ($b && $b->gambar) ? asset('storage/'.$b->gambar) : '' }}" alt="Pratinjau gambar">
                    <span id="preview-empty" class="text-sm text-slate-400 {{ ($b && $b->gambar) ? 'hidden' : '' }}">Belum ada gambar</span>
                </div>
                <input id="gambar" type="file" name="gambar" accept="image/*"
                       class="block w-full text-sm text-slate-600 file:mr-3 file:h-9 file:px-4 file:rounded-lg file:border-0 file:bg-slate-100 file:text-slate-700 file:font-medium hover:file:bg-slate-200">
                <p class="text-xs text-slate-500 mt-2">JPG atau PNG, maksimal 2 MB.@if ($b) Kosongkan jika tidak ingin mengganti gambar.@endif</p>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-2 mt-6">
        <a href="{{ route('berita.index') }}"
           class="inline-flex items-center h-10 px-5 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        <button class="inline-flex items-center h-10 px-5 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
            {{ $b ? 'Simpan perubahan' : 'Terbitkan berita' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.getElementById('gambar').addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        document.getElementById('preview-empty').classList.add('hidden');
    });
</script>
@endpush