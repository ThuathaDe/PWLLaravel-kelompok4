<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ================= Sisi Pelanggan (tanpa login) =================
Route::get('/pesan/{nomorMeja}', [PemesananController::class, 'index'])->name('pemesanan.index');
Route::post('/pesan', [PemesananController::class, 'store'])->name('pemesanan.store');
Route::get('/pesan/selesai/{pesanan}', [PemesananController::class, 'selesai'])->name('pemesanan.selesai');

// ================= Sisi Admin =================
// Catatan: middleware 'auth' sengaja belum dipasang supaya bisa langsung dites.
// Setelah sistem login siap, bungkus group ini dengan Route::middleware(['auth'])->group(...)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produk', ProdukController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::post('/pesanan/{pesanan}/status', [DashboardController::class, 'ubahStatus'])->name('pesanan.ubahStatus');

    
});
