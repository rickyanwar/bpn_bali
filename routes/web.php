<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggabunganController;

Route::get('/', function () {
    return redirect('/login');
});


Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);


Route::post('penggabungan/teruskan/{id}', [PenggabunganController::class, 'teruskan'])->name('penggabungan.teruskan');
Route::get('penggabungan/print/{id}', [PenggabunganController::class, 'print'])->name('penggabungan.print');
Route::resource('penggabungan', PenggabunganController::class);
Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');

Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');



Auth::routes();
