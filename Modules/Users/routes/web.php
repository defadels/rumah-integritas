<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\FormController;
use Modules\Users\Http\Controllers\FormMakanMinumController;
use Modules\Users\Http\Controllers\FormHasilPeriksaController;
use Modules\Users\Http\Controllers\FormBarangPakaiHabisController;
use Modules\Users\Http\Controllers\FormKartuKendaliController;

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
    /*user*/
    Route::get(config('app.backend').'/'.'users',[UsersController::class, 'index'])->middleware('can:view users')->name('users');
    Route::get(config('app.backend').'/'.'users/add', [UsersController::class, 'create'])->middleware('can:create users')->name('users.create');
    Route::post(config('app.backend').'/'.'users/add', [UsersController::class, 'store'])->middleware('can:create users');
    Route::get(config('app.backend').'/'.'users/edit/{id}', [UsersController::class, 'edit'])->middleware('can:update users')->name('users.update');
    Route::post(config('app.backend').'/'.'users/edit/{id}', [UsersController::class, 'update'])->middleware('can:update users');
    Route::post(config('app.backend').'/'.'users/delete', [UsersController::class, 'destroy'])->middleware('can:delete users')->name('users.delete');
    Route::post(config('app.backend').'/'.'users/delete-all', [UsersController::class, 'destroyAll'])->middleware('can:delete users')->name('users.delete.all');
    Route::get(config('app.backend').'/'.'users/password/{id}', [UsersController::class, 'editPassword'])->middleware('can:update users')->name('users.password');
    Route::post(config('app.backend').'/'.'users/password/{id}', [UsersController::class, 'updatePassword'])->middleware('can:update users');

    /*roles*/
    Route::get(config('app.backend').'/'.'users/roles', [UsersController::class, 'indexRole'])->middleware('can:view roles')->name('users.roles');
    Route::get(config('app.backend').'/'.'users/roles/add', [UsersController::class, 'createRole'])->middleware('can:create roles')->name('users.roles.create');
    Route::post(config('app.backend').'/'.'users/roles/add', [UsersController::class, 'storeRole'])->middleware('can:create roles');
    Route::get(config('app.backend').'/'.'users/roles/edit/{id}', [UsersController::class, 'editRole'])->middleware('can:update roles')->name('users.roles.update');
    Route::post(config('app.backend').'/'.'users/roles/edit/{id}', [UsersController::class, 'updateRole'])->middleware('can:update roles');
    Route::post(config('app.backend').'/'.'users/roles/delete', [UsersController::class, 'destroyRole'])->middleware('can:delete roles');
    Route::post(config('app.backend').'/'.'users/roles/delete-all', [UsersController::class, 'destroyRoleAll'])->middleware('can:delete roles');

    /*permission*/
    Route::get(config('app.backend').'/'.'users/roles/permission/{id}', [UsersController::class, 'editPermission'])->middleware('can:update roles')->name('users.roles.permission');
    Route::post(config('app.backend').'/'.'users/roles/permission/{id}', [UsersController::class, 'updatePermission'])->middleware('can:update roles');

    /*logs*/
    Route::get(config('app.backend').'/'.'users/logs', [UsersController::class, 'indexLogs'])->name('users.logs')->middleware('can:view logs');

    /*profile*/
    Route::get(config('app.backend').'/'.'profile',[UsersController::class, 'indexProfile'])->name('profile');
    Route::post(config('app.backend').'/'.'profile',[UsersController::class, 'updateProfile']);
    Route::get(config('app.backend').'/'.'profile/password', [UsersController::class, 'editProfilePassword'])->name('profile.password');
    Route::post(config('app.backend').'/'.'profile/password', [UsersController::class, 'updateProfilePassword']);
    Route::get(config('app.backend').'/'.'profile/avatar/{filename}', [UsersController::class, 'viewAvatar'])->name('profile.avatar');

});
