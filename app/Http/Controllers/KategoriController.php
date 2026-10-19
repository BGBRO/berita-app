<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('beritas')->latest()->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nama' => 'required|string|max:100']);
        Kategori::create($data);
        return back()->with('success', 'Kategori ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate(['nama' => 'required|string|max:100']);
        $kategori->update($data);
        return back()->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
