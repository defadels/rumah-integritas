<?php

use Illuminate\Support\Facades\Route;
use Modules\Dapodik\Http\Controllers\DapodikController;

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
    /*peserta didik*/
    Route::get(config('app.backend').'/'.'dapodik/siswa',[DapodikController::class, 'indexSiswa'])->name('dapodik.siswa')->middleware('can:view siswa');
    Route::post(config('app.backend').'/'.'dapodik/siswa/delete', [DapodikController::class, 'destroySiswa'])->middleware('can:delete siswa');
    Route::post(config('app.backend').'/'.'dapodik/siswa/delete-all', [DapodikController::class, 'destroySiswaAll'])->middleware('can:delete siswa');

    /*kepala sekolah*/
    Route::get(config('app.backend').'/'.'dapodik/kepala-sekolah',[DapodikController::class, 'indexKepalaSekolah'])->name('dapodik.kepala-sekolah')->middleware('can:view kepala sekolah');
    Route::get(config('app.backend').'/'.'dapodik/kepala-sekolah/import',[DapodikController::class, 'importKepalaSekolah'])->name('dapodik.kepala-sekolah.import')->middleware('can:create kepala sekolah');
    Route::post(config('app.backend').'/'.'dapodik/kepala-sekolah/import',[DapodikController::class, 'storeKepalaSekolah'])->name('dapodik.kepala-sekolah.import')->middleware('can:create kepala sekolah');
    Route::post(config('app.backend').'/'.'dapodik/kepala-sekolah/delete', [DapodikController::class, 'destroyKepalaSekolah'])->middleware('can:delete kepala sekolah');
    Route::post(config('app.backend').'/'.'dapodik/kepala-sekolah/delete-all', [DapodikController::class, 'destroyKepalaSekolahAll'])->middleware('can:delete kepala sekolah');

    /*guru*/
    Route::get(config('app.backend').'/'.'dapodik/guru',[DapodikController::class, 'indexGuru'])->name('dapodik.guru')->middleware('can:view guru');
    Route::get(config('app.backend').'/'.'dapodik/guru/import',[DapodikController::class, 'importGuru'])->name('dapodik.guru.import')->middleware('can:create guru');
    Route::post(config('app.backend').'/'.'dapodik/guru/import',[DapodikController::class, 'storeGuru'])->name('dapodik.guru.import')->middleware('can:create guru');
    Route::post(config('app.backend').'/'.'dapodik/guru/delete', [DapodikController::class, 'destroyGuru'])->middleware('can:delete guru');
    Route::post(config('app.backend').'/'.'dapodik/guru/delete-all', [DapodikController::class, 'destroyGuruAll'])->middleware('can:delete guru');

    Route::get(config('app.backend').'/'.'dapodik/non-guru',[DapodikController::class, 'indexNonGuru'])->name('dapodik.non-guru');

    /*sekolah*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah',[DapodikController::class, 'indexSekolah'])->name('dapodik.sekolah')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah/import',[DapodikController::class, 'importSekolah'])->name('dapodik.sekolah.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/import',[DapodikController::class, 'storeSekolah'])->name('dapodik.sekolah.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/delete', [DapodikController::class, 'destroySekolah'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/delete-all', [DapodikController::class, 'destroySekolahAll'])->middleware('can:delete sekolah');

    /*sekolah administrasi*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-adm',[DapodikController::class, 'indexSekolahAdministrasi'])->name('dapodik.sekolah-adm')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-adm/import',[DapodikController::class, 'importSekolahAdministrasi'])->name('dapodik.sekolah-adm.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-adm/import',[DapodikController::class, 'storeSekolahAdministrasi'])->name('dapodik.sekolah-adm.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-adm/delete', [DapodikController::class, 'destroySekolahAdministrasi'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-adm/delete-all', [DapodikController::class, 'destroySekolahAdministrasiAll'])->middleware('can:delete sekolah');

    /*sekolah rombel*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-rombel',[DapodikController::class, 'indexSekolahRombel'])->name('dapodik.sekolah-rombel')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-rombel/import',[DapodikController::class, 'importSekolahRombel'])->name('dapodik.sekolah-rombel.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-rombel/import',[DapodikController::class, 'storeSekolahRombel'])->name('dapodik.sekolah-rombel.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-rombel/delete', [DapodikController::class, 'destroySekolahRombel'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-rombel/delete-all', [DapodikController::class, 'destroySekolahRombelAll'])->middleware('can:delete sekolah');

    /*sekolah siswa*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-siswa',[DapodikController::class, 'indexSekolahSiswaRekap'])->name('dapodik.sekolah-siswa')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-siswa/import',[DapodikController::class, 'importSekolahSiswaRekap'])->name('dapodik.sekolah-siswa.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-siswa/import',[DapodikController::class, 'storeSekolahSiswaRekap'])->name('dapodik.sekolah-siswa.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-siswa/delete', [DapodikController::class, 'destroySekolahSiswaRekap'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-siswa/delete-all', [DapodikController::class, 'destroySekolahSiswaRekapAll'])->middleware('can:delete sekolah');

    /*sekolah ruang kelas*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-ruang-kelas',[DapodikController::class, 'indexSekolahRuangKelas'])->name('dapodik.sekolah-ruang-kelas')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-ruang-kelas/import',[DapodikController::class, 'importSekolahRuangKelas'])->name('dapodik.sekolah-ruang-kelas.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-kelas/import',[DapodikController::class, 'storeSekolahRuangKelas'])->name('dapodik.sekolah-ruang-kelas.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-kelas/delete', [DapodikController::class, 'destroySekolahRuangKelas'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-kelas/delete-all', [DapodikController::class, 'destroySekolahRuangKelasAll'])->middleware('can:delete sekolah');

    /*sekolah laboratorium*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-lab',[DapodikController::class, 'indexSekolahLab'])->name('dapodik.sekolah-lab')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-lab/import',[DapodikController::class, 'importSekolahLab'])->name('dapodik.sekolah-lab.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lab/import',[DapodikController::class, 'storeSekolahLab'])->name('dapodik.sekolah-lab.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lab/delete', [DapodikController::class, 'destroySekolahLab'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lab/delete-all', [DapodikController::class, 'destroySekolahLabAll'])->middleware('can:delete sekolah');

    /*sekolah ruang guru*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-ruang-guru',[DapodikController::class, 'indexSekolahRuangGuru'])->name('dapodik.sekolah-ruang-guru')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-ruang-guru/import',[DapodikController::class, 'importSekolahRuangGuru'])->name('dapodik.sekolah-ruang-guru.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-guru/import',[DapodikController::class, 'storeSekolahRuangGuru'])->name('dapodik.sekolah-ruang-guru.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-guru/delete', [DapodikController::class, 'destroySekolahRuangGuru'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-ruang-guru/delete-all', [DapodikController::class, 'destroySekolahRuangGuruAll'])->middleware('can:delete sekolah');

    /*sekolah wc*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-wc',[DapodikController::class, 'indexSekolahWc'])->name('dapodik.sekolah-wc')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-wc/import',[DapodikController::class, 'importSekolahWc'])->name('dapodik.sekolah-wc.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-wc/import',[DapodikController::class, 'storeSekolahWc'])->name('dapodik.sekolah-wc.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-wc/delete', [DapodikController::class, 'destroySekolahWc'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-wc/delete-all', [DapodikController::class, 'destroySekolahWcAll'])->middleware('can:delete sekolah');

    /*sekolah lain-lain*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah-lain',[DapodikController::class, 'indexSekolahLain'])->name('dapodik.sekolah-lain')->middleware('can:view sekolah');
    Route::get(config('app.backend').'/'.'dapodik/sekolah-lain/import',[DapodikController::class, 'importSekolahLain'])->name('dapodik.sekolah-lain.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lain/import',[DapodikController::class, 'storeSekolahLain'])->name('dapodik.sekolah-lain.import')->middleware('can:create sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lain/delete', [DapodikController::class, 'destroySekolahLain'])->middleware('can:delete sekolah');
    Route::post(config('app.backend').'/'.'dapodik/sekolah-lain/delete-all', [DapodikController::class, 'destroySekolahLainAll'])->middleware('can:delete sekolah');

    /*peserta didik sekolah*/
    Route::get(config('app.backend').'/'.'dapodik/sekolah/{npsn}/siswa',[DapodikController::class, 'indexSekolahSiswa'])->name('dapodik.sekolah.siswa')->middleware('can:view siswa');
    Route::get(config('app.backend').'/'.'dapodik/sekolah/{npsn}/siswa/import',[DapodikController::class, 'importSekolahSiswa'])->name('dapodik.sekolah.siswa.import')->middleware('can:create siswa');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/{npsn}/siswa/import',[DapodikController::class, 'storeSekolahSiswa'])->name('dapodik.sekolah.siswa.import')->middleware('can:create siswa');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/siswa/delete', [DapodikController::class, 'destroySekolahSiswa'])->middleware('can:delete siswa');
    Route::post(config('app.backend').'/'.'dapodik/sekolah/siswa/delete-all', [DapodikController::class, 'destroySekolahSiswaAll'])->middleware('can:delete siswa');
});
