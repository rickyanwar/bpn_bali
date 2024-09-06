<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggabunganController;
use App\Http\Controllers\PemecahanController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\PenataanBatasController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});



Route::get('display/', [DashboardController::class, 'display'])->name('dashboard.display');
Route::get('display/get-list', [DashboardController::class, 'getListdisplay'])->name('dashboard.get.list');


// Group routes that need authentication
Route::middleware(['auth'])->group(function () {


    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);


    Route::post('penataan_batas/tolak/{id}', [PenataanBatasController::class, 'tolak'])->name('penataan_batas.tolak');
    Route::post('penataan_batas/teruskan/{id}', [PenataanBatasController::class, 'teruskan'])->name('penataan_batas.teruskan');
    Route::get('penataan_batas/print/{id}', [PenataanBatasController::class, 'print'])->name('penataan_batas.print');
    Route::resource('penataan_batas', PenataanBatasController::class);


    Route::post('penggabungan/tolak/{id}', [PenggabunganController::class, 'tolak'])->name('penggabungan.tolak');
    Route::post('penggabungan/teruskan/{id}', [PenggabunganController::class, 'teruskan'])->name('penggabungan.teruskan');
    Route::get('penggabungan/print/{id}', [PenggabunganController::class, 'print'])->name('penggabungan.print');
    Route::resource('penggabungan', PenggabunganController::class);


    Route::post('pemecahan/tolak/{id}', [PemecahanController::class, 'tolak'])->name('pemecahan.tolak');
    Route::post('pemecahan/teruskan/{id}', [PemecahanController::class, 'teruskan'])->name('pemecahan.teruskan');
    Route::get('pemecahan/print/{id}', [PemecahanController::class, 'print'])->name('pemecahan.print');
    Route::resource('pemecahan', PemecahanController::class);


    Route::post('pengukuran/tolak/{id}', [PengukuranController::class, 'tolak'])->name('pengukuran.tolak');
    Route::post('pengukuran/teruskan/{id}', [PengukuranController::class, 'teruskan'])->name('pengukuran.teruskan');
    Route::get('pengukuran/print/{id}', [PengukuranController::class, 'print'])->name('pengukuran.print');
    Route::resource('pengukuran', PengukuranController::class);


    // User password reset routes
    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
});

Auth::routes();
