<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('list_pengaduan', [App\Http\Controllers\ComplaintController::class, 'adminIndex'])->name('list_pengaduan');
    Route::get('detail_pengaduan/{id}', [App\Http\Controllers\ComplaintController::class, 'show'])->name('detail_pengaduan');
    Route::put('tanggapi_pengaduan/{id}', [App\Http\Controllers\ComplaintController::class, 'process'])->name('tanggapi_pengaduan');
    Route::get('laporan_pengaduan', [App\Http\Controllers\ComplaintController::class, 'laporan'])->name('laporan');
    Route::get('cetak_laporan', [App\Http\Controllers\ComplaintController::class, 'cetakPdf'])->name('cetak_laporan');
});
Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('daftar_pengaduan', [App\Http\Controllers\ComplaintController::class, 'userIndex'])->name('daftar_pengaduan');
    Route::get('buat_pengaduan', [App\Http\Controllers\ComplaintController::class, 'create'])->name('buat_pengaduan');
    Route::post('simpan_pengaduan', [App\Http\Controllers\ComplaintController::class, 'store'])->name('simpan_pengaduan');

});