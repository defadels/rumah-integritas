<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\FormLogin;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/manage/login');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/counter', Counter::class);
Route::get('/form-login', FormLogin::class)->name('form.login');
Route::get('/generatelink',function(){
    $target = storage_path('app/hasil');
    $to = $_SERVER['DOCUMENT_ROOT'] . '/hasil';
    symlink($target,$to);
})->middleware('auth');

require __DIR__.'/auth.php';
