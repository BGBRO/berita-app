<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalBerita   = Berita::count();
        $totalKategori = Kategori::count();
        $beritaSaya    = Berita::where('user_id', Auth::id())->count();
        $bulanIni      = Berita::whereYear('tanggal', now()->year)
                               ->whereMonth('tanggal', now()->month)->count();

        $perKategori = Kategori::withCount('beritas')->orderByDesc('beritas_count')->get();
        $terbaru     = Berita::with(['kategori', 'user'])->latest()->take(6)->get();

        return view('dashboard', compact(
            'totalBerita', 'totalKategori', 'beritaSaya', 'bulanIni', 'perKategori', 'terbaru'
        ));
    }
}