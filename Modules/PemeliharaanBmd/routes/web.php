<?php

use Illuminate\Support\Facades\Route;
use Modules\PemeliharaanBmd\Http\Controllers\PemeliharaanBmdController;

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
    // Route::resource('pemeliharaanbmd', PemeliharaanBmdController::class)->names('pemeliharaanbmd');
    #route form pemeliharaan bmd
    Route::get(config('app.backend').'/'.'form-pelihara/create', [PemeliharaanBmdController::class,'create'])->name('form.pelihara.create');
    Route::post(config('app.backend').'/'.'form-pelihara/create', [PemeliharaanBmdController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-pelihara/edit/{id}', [PemeliharaanBmdController::class,'edit'])->name('form.pelihara.edit');
    Route::post(config('app.backend').'/'.'form-pelihara/edit/{id}', [PemeliharaanBmdController::class, 'update'])->name('form.pelihara.update');
    Route::post(config('app.backend').'/'.'form-pelihara/delete', [PemeliharaanBmdController::class, 'destroy'])->name('form.pelihara.delete');
});
