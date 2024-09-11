<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggabunganController;
use App\Http\Controllers\PemecahanController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return redirect('/login');
// });

Auth::routes();



Route::get('display/', [DashboardController::class, 'display'])->name('dashboard.display');
Route::get('display/get-list', [DashboardController::class, 'getListdisplay'])->name('dashboard.get.list');


// Group routes that need authentication
Route::middleware(['auth:api','auth:web'])->group(function () {


    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);


    Route::post('permohonan/tolak/{id}', [PermohonanController::class, 'tolak'])->name('permohonan.tolak');
    Route::post('permohonan/teruskan/{id}', [PermohonanController::class, 'teruskan'])->name('permohonan.teruskan');
    Route::get('permohonan/print/{id}', [PermohonanController::class, 'print'])->name('permohonan.print');

    Route::get('permohonan/print/pemberitahuan/{id}', [PermohonanController::class, 'printPemberitahuan'])->name('permohonan.print.pemberitahuan');

    Route::resource('permohonan', PermohonanController::class);


    // User password reset routes
    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
});
