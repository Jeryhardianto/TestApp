<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LihatTransaksi;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', HomeController::class)->name('home');
Route::get('/lihattransaksi', [LihatTransaksi::class, 'index'])->name('lihattransaksi');
Route::get('/caritransaksi', [LihatTransaksi::class, 'cari'])->name('cari');
Route::resource('/kategori', KategoriController::class); 
Route::post('/kategori/getidKat', [KategoriController::class, 'getIdKategori'])->name('getIdKategori');
Route::resource('/transaksi', TransaksiController::class);