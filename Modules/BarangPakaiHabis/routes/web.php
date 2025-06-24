<?php

use Illuminate\Support\Facades\Route;
use Modules\BarangPakaiHabis\Http\Controllers\BarangPakaiHabisController;

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

Route::middleware('auth')->group(function () {
    // Route::resource('barangpakaihabis', BarangPakaiHabisController::class)->names('barangpakaihabis');
    #route form barang pakai habis
    Route::get(config('app.backend').'/'.'form-barang-pakai-habis/create', [BarangPakaiHabisController::class,'create'])->name('form.barang.pakai.habis.create');
    Route::post(config('app.backend').'/'.'form-barang-pakai-habis/create', [BarangPakaiHabisController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-barang-pakai-habis/edit/{id}', [BarangPakaiHabisController::class,'edit'])->name('form.barang.pakai.habis.edit');
    Route::post(config('app.backend').'/'.'form-barang-pakai-habis/edit/{id}', [BarangPakaiHabisController::class,'update'])->name('form.barang.pakai.habis.update');
    Route::post(config('app.backend').'/'.'form-barang-pakai-habis/delete', [BarangPakaiHabisController::class,'destroy'])->name('form.barang.pakai.habis.delete');
});
