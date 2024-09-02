<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggabunganController;
use App\Http\Controllers\PemecahanController;

Route::get('/', function () {
    return redirect('/login');
});


// Group routes that need authentication
Route::middleware(['auth'])->group(function () {


    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    Route::post('penggabungan/teruskan/{id}', [PenggabunganController::class, 'teruskan'])->name('penggabungan.teruskan');
    Route::get('penggabungan/print/{id}', [PenggabunganController::class, 'print'])->name('penggabungan.print');
    Route::resource('penggabungan', PenggabunganController::class);


    Route::post('pemecahan/teruskan/{id}', [PemecahanController::class, 'teruskan'])->name('pemecahan.teruskan');
    Route::get('pemecahan/print/{id}', [PemecahanController::class, 'print'])->name('pemecahan.print');
    Route::resource('pemecahan', PemecahanController::class);

    // User password reset routes
    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
});

Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');

Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');



Auth::routes();
