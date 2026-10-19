<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return redirect()->route('berita.index');
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