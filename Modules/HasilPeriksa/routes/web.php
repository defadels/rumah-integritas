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
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan', [HasilPeriksaController::class,'index'])->name('form.hasil.index');
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/create', [HasilPeriksaController::class,'create'])->name('form.hasil.create');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/create', [HasilPeriksaController::class, 'store']);
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/edit/{id}', [HasilPeriksaController::class,'edit'])->name('form.hasil.edit');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/edit/{id}', [HasilPeriksaController::class,'update'])->name('form.hasil.update');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/delete', [HasilPeriksaController::class, 'destroy'])->name('form.hasil.delete');
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/users/history', [HasilPeriksaController::class, 'getFilesUser'])->name('form.hasil.history');
    
    // Approval routes
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/detail/{id}', [HasilPeriksaController::class,'detail'])->name('form.hasil.detail');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/approve', [HasilPeriksaController::class,'approve'])->name('form.hasil.approve');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/reject', [HasilPeriksaController::class,'reject'])->name('form.hasil.reject');
    
    // Reply routes
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/reply/{id}', [HasilPeriksaController::class,'reply'])->name('form.hasil.reply');
    Route::post(config('app.backend').'/'.'form-hasil-pemeriksaan/reply', [HasilPeriksaController::class,'storeReply'])->name('form.hasil.reply.store');
    Route::get(config('app.backend').'/'.'form-hasil-pemeriksaan/conversation/{id}', [HasilPeriksaController::class,'conversation'])->name('form.hasil.conversation');
});
