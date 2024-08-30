<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['prefix' => 'v1'], function () {




    Route::get('/user/search', [App\Http\Controllers\Api\UserController::class, 'search'])->name('user.search');

    //Wilayah Indonesia
    Route::group(['prefix' => 'regional'], function () {
        Route::get('provinsi', [App\Http\Controllers\Api\WilayahIndonesiaController::class, 'provinsi'])->name('regional.provinsi');
        Route::get('kabupaten', [App\Http\Controllers\Api\WilayahIndonesiaController::class, 'kabupatenKota'])->name('regional.kota');
        Route::get('kecamatan', [App\Http\Controllers\Api\WilayahIndonesiaController::class, 'kecamatan'])->name('regional.kecamatan');
        Route::get('desa', [App\Http\Controllers\Api\WilayahIndonesiaController::class, 'kelurahanDesa'])->name('regional.desa');
        ;
    });

    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/verification', [App\Http\Controllers\Api\AuthController::class, 'verify']);
    Route::post('/send-otp', [App\Http\Controllers\Api\AuthController::class, 'sendOtp']);
    Route::post('/forget-password', [App\Http\Controllers\Api\AuthController::class, 'forgetPassword']);
    //API route for login user
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

    //Protecting Routes
    Route::group(['middleware' => ['auth:api,web']], function () {
        // Route::get('/profile', [App\Http\Controllers\Api\AuthController::class, 'profile']);

        // // API route for logout user
        // Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
        // Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);
        // Route::post('/profile/update', [App\Http\Controllers\Api\AuthController::class, 'updateProfile']);

        Route::apiResource('req_penggabungan', App\Http\Controllers\Api\PenggabunganController::class);

    });

});
