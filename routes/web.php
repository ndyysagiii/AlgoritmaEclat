<?php

use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'login'])->name('login.store');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi')->middleware('auth');
Route::post('/transaksi-store', [TransaksiController::class, 'store'])->name('transaksi.store')->middleware('auth');
Route::put('/transaksi-update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update')->middleware('auth');
Route::delete('/transaksi-delete/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete')->middleware('auth');

Route::get('/algoritma', [AlgoritmaController::class, 'index'])->name('algoritma')->middleware('auth');
Route::get('/trasnsaksi/filter', [AlgoritmaController::class, 'filter'])->name('transasksi.filter')->middleware('auth');

Route::get('/hasil', [HasilController::class, 'index'])->name('hasil')->middleware('auth');
Route::get('/hasil-detail/{id}', [HasilController::class, 'show'])->name('hasil.detail')->middleware('auth');
Route::get('/hasil/{id}/pdf', [HasilController::class, 'generatePDF'])->name('hasil.pdf')->middleware('auth');

Route::get('/proses', [ProsesController::class, 'index'])->name('prosoes')->middleware('auth');
Route::get('/transaksi/filter', [ProsesController::class, 'filter'])->name('transaksi.filter')->middleware('auth');

Route::post('transaksi/import', [TransaksiController::class, 'import'])->name('transaksi.import')->middleware('auth');
