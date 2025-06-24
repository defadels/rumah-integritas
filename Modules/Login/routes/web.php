<?php

use Illuminate\Support\Facades\Route;
use Modules\Login\Http\Controllers\LoginController;

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

Route::middleware('guest')->group(function () {
    Route::get(config('app.backend').'/'.'login', [LoginController::class, 'index'])->name('app.login');
    Route::post(config('app.backend').'/'.'login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get(config('app.backend').'/'.'logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('app.logout');
});


