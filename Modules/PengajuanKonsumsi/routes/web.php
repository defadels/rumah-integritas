<?php

use Illuminate\Support\Facades\Route;
use Modules\PengajuanKonsumsi\Http\Controllers\PengajuanKonsumsiController;

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
    // Route::resource('pengajuankonsumsi', PengajuanKonsumsiController::class)->names('pengajuankonsumsi');

    #route form makanminum
    Route::get(config('app.backend').'/'.'form-makan-minum/create', [PengajuanKonsumsiController::class,'create'])->name('form.makan.create');
    Route::post(config('app.backend').'/'.'form-makan-minum/create', [PengajuanKonsumsiController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-makan-minum/edit/{id}', [PengajuanKonsumsiController::class,'edit'])->name('form.makan.edit');
    Route::post(config('app.backend').'/'.'form-makan-minum/edit/{id}', [PengajuanKonsumsiController::class,'update'])->name('form.makan.update');
    Route::post(config('app.backend').'/'.'form-makan-minum/delete', [PengajuanKonsumsiController::class,'destroy'])->name('form.makan.delete');
});
