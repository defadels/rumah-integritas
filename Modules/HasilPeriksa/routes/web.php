<?php

use Illuminate\Support\Facades\Route;
use Modules\HasilPeriksa\Http\Controllers\HasilPeriksaController;

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
    // Route::resource('hasilperiksa', HasilPeriksaController::class)->names('hasilperiksa');
    #route form pemeriksaan
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/create', [HasilPeriksaController::class,'create'])->name('form.hasil.create');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/create', [HasilPeriksaController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/edit/{id}', [HasilPeriksaController::class,'edit'])->name('form.hasil.edit');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/edit/{id}', [HasilPeriksaController::class,'update'])->name('form.hasil.update');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/delete', [HasilPeriksaController::class, 'destroy'])->name('form.hasil.delete');
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/users/history', [HasilPeriksaController::class, 'getFilesUser'])->name('form.hasil.history');
});
