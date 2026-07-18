<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;

// ================= Beranda =================
Route::get('/', function () {
    return view('welcome');
});

// ================= Login Admin =================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ================= Sisi Pelanggan (tanpa login) =================
Route::get('/pelanggan/pilih-meja', function () {
    return view('pelanggan.pilih-meja');
})->name('pelanggan.pilihMeja');

Route::get('/pelanggan/mulai', function (\Illuminate\Http\Request $request) {
    return redirect()->route('pemesanan.index', $request->query('nomor_meja'));
})->name('pelanggan.mulaiPesan');

Route::get('/pesan/{nomorMeja}', [PemesananController::class, 'index'])->name('pemesanan.index');
Route::post('/pesan', [PemesananController::class, 'store'])->name('pemesanan.store');
Route::get('/pesan/selesai/{pesanan}', [PemesananController::class, 'selesai'])->name('pemesanan.selesai');

// ================= Sisi Admin (WAJIB login) =================
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('produk', ProdukController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::post('/pesanan/{pesanan}/status', [DashboardController::class, 'ubahStatus'])->name('pesanan.ubahStatus');
    
    Route::get('/pesanan/buat', [DashboardController::class, 'buatPesanan'])->name('pesanan.buat');
});