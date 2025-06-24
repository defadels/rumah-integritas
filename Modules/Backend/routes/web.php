<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controllers\BackendController;

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
    Route::get(config('app.backend').'/', [BackendController::class, 'index'])->name('app.backend');
});

//Route::get(config('app.backend').'/', [BackendController::class, 'index'])->name('app.backend');
