<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanBulanan;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\PerekamanController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

  Route::prefix('Master')->group(function () {
    Route::get('/user/profile', [UserController::class, 'myprofile'])->name('user.profile');
    Route::resource('user', UserController::class)->parameters(['user' => 'id',]);
    Route::post('/user/password', [UserController::class, 'change_password'])->name('user-change-password');

    Route::resource('seksi', SeksiController::class)->parameters(['seksi' => 'id',]);
    Route::resource('barang', BarangController::class)->parameters(['barang' => 'id',]);
    Route::post('/barang/stok', [BarangController::class, 'updateStok'])->name('barang.updateStok');
  });

  Route::prefix('Transaksi')->group(function () {
    Route::resource('transaksi', TransaksiController::class)->parameters(['transaksi' => 'id',]);
    Route::put('/transaksi/approve/{id}', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::put('/transaksi/reject/{id}', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    Route::put('/transaksi/selesai/{id}', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    Route::resource('perekaman', PerekamanController::class)->parameters(['perekaman' => 'id',]);
    Route::get('/perekaman/get/barang/{id}', [PerekamanController::class, 'databarang'])->name('perekaman.get.barang');
    Route::put('/perekaman/confirm/{id}', [PerekamanController::class, 'confirm'])->name('perekaman.confirm');
    Route::get('/perekaman/cetak/{id}', [PerekamanController::class, 'cetak'])->name('perekaman.cetak');

    Route::resource('opname', OpnameController::class)->parameters(['opname' => 'id',]);
    Route::post('/reset/opname', [OpnameController::class, 'resetOpname'])->name('opname.reset');
    Route::post('/reset/stok', [OpnameController::class, 'resetStok'])->name('opname.reset.stok');
    Route::post('/reset/transaksi', [OpnameController::class, 'resetTransaksi'])->name('opname.reset.transaksi');
    Route::post('/opname/cetak', [OpnameController::class, 'cetak'])->name('opname.cetak');

    Route::resource('laporan-bulanan', LaporanBulanan::class)->parameters(['laporan' => 'id',]);
    Route::get('/laporan-bulanan/{month}/{year}/{seksi}', [LaporanBulanan::class, 'getDetail'])->name('laporan-bulanan.detail');
  });

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
