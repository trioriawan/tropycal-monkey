<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Masukin ini ke dalam Route Group Middleware lo
Route::middleware(['auth'])->group(function () {
    // ... rute lainnya ...

    // RAPIH & SATU PINTU
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/detail/{no_transaksi}', [LaporanController::class, 'show'])->name('laporan.detail');
    Route::get('/laporan/print-nota/{no_transaksi}', [LaporanController::class, 'printNota'])->name('laporan.print');
});

// 1. Pintu Masuk
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 2. Area Terlarang (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']); 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Taruh route POS lainnya di sini juga nanti...
});

// Hapus yang lama, ganti pake ini:
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Master Produk
Route::resource('produk', ProdukController::class);

// Input Transaksi
Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
Route::post('/penerimaan/simpan', [PenerimaanController::class, 'store'])->name('penerimaan.store');
Route::resource('pengeluaran', PengeluaranController::class);


use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    // ... route dashboard lo ...
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});




// Pastikan di dalam middleware auth
//Route::middleware(['auth'])->group(function () {
    // Rute utama laporan
   // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    
    // Rute Detail (Ini yang bikin error kalau belum ada)
    //Route::get('/laporan/detail/{no_transaksi}', [LaporanController::class, 'show'])->name('laporan.show');
//});

// Laporan (Satu Pintu lewat LaporanController)
// Route Laporan Terpusat
//Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
//Route::get('/laporan/detail/{no_transaksi}', [LaporanController::class, 'show'])->name('laporan.detail');

Route::get('/laporan/print-nota/{no_transaksi}', [LaporanController::class, 'printNota'])->name('laporan.print');
// Untuk Excel/PDF bisa pake library 'Maatwebsite/Laravel-Excel' atau 'dompdf' nanti

Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::post('/produk/import', [App\Http\Controllers\ProdukController::class, 'import'])->name('produk.import');

Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');