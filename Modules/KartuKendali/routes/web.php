<?php

use Illuminate\Support\Facades\Route;
use Modules\KartuKendali\Http\Controllers\KartuKendaliController;

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
    // Route::resource('kartukendali', KartuKendaliController::class)->names('kartukendali');
    #route form kartu kendali
    Route::get(config('app.backend').'/'.'form-kartu-kendali/create', [KartuKendaliController::class,'create'])->name('form.kartu.kendali.create');
    Route::post(config('app.backend').'/'.'form-kartu-kendali/create', [KartuKendaliController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-kartu-kendali/edit/{id}', [KartuKendaliController::class,'edit'])->name('form.kartu.kendali.edit');
    Route::post(config('app.backend').'/'.'form-kartu-kendali/edit/{id}', [KartuKendaliController::class,'update'])->name('form.kartu.kendali.update');
    Route::post(config('app.backend').'/'.'form-kartu-kendali/delete', [KartuKendaliController::class,'destroy'])->name('form.kartu.kendali.delete');
});
