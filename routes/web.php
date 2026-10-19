<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cetak PDF (harus di atas Route::resource agar tidak bentrok dengan berita/{berita})
    Route::get('berita/cetak-semua', [BeritaController::class, 'cetakSemua'])->name('berita.cetak-semua');
    Route::get('berita/{berita}/cetak', [BeritaController::class, 'cetak'])->name('berita.cetak');

    // Parameter dipaksa bernama {berita}. Tanpa ini Laravel menyingkat "berita"
    // menjadi {beritum}, sehingga model tidak ter-bind ke $berita di controller.
    Route::resource('berita', BeritaController::class)
        ->parameters(['berita' => 'berita']);

    Route::resource('kategori', KategoriController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameters(['kategori' => 'kategori']);
});

require __DIR__.'/auth.php';
