<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with(['kategori', 'user'])->latest('tanggal')->paginate(10);
        return view('berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal'     => 'required|date',
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'gambar'      => 'nullable|image|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }
        $data['user_id'] = auth()->id();

        Berita::create($data);
        return redirect()->route('berita.index')->with('success', 'Berita ditambahkan.');
    }

    public function show(Berita $berita)
    {
        $berita->load(['kategori', 'user']);

        // Berita lain dengan kategori yang sama
        $terkait = Berita::with('kategori')
            ->where('kategori_id', $berita->kategori_id)
            ->where('id', '!=', $berita->id)
            ->latest('tanggal')
            ->take(3)
            ->get();

        return view('berita.show', compact('berita', 'terkait'));
    }

    // Cetak satu berita ke PDF
    public function cetak(Berita $berita)
    {
        $berita->load(['kategori', 'user']);
        $gambar = $this->gambarDataUri($berita->gambar);

        return Pdf::loadView('berita.pdf', compact('berita', 'gambar'))
            ->setPaper('a4', 'portrait')
            ->stream('berita-' . Str::slug($berita->judul) . '.pdf');
    }

    // Cetak daftar semua berita ke PDF
    public function cetakSemua()
    {
        $beritas = Berita::with(['kategori', 'user'])->latest('tanggal')->get();

        return Pdf::loadView('berita.pdf-daftar', compact('beritas'))
            ->setPaper('a4', 'portrait')
            ->stream('daftar-berita.pdf');
    }

    // Dompdf lebih aman membaca gambar lokal sebagai data URI
    private function gambarDataUri(?string $path): ?string
    {
        if (! $path || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        $mime = Storage::disk('public')->mimeType($path) ?: 'image/jpeg';

        return 'data:' . $mime . ';base64,' . base64_encode(Storage::disk('public')->get($path));
    }

    public function edit(Berita $berita)
    {
        $kategoris = Kategori::all();
        return view('berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'tanggal'     => 'required|date',
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'gambar'      => 'nullable|image|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('berita.index')->with('success', 'Berita diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();
        return redirect()->route('berita.index')->with('success', 'Berita dihapus.');
    }
}
