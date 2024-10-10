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
        // Explicitly named routes for permohonan
        Route::post('permohonan/selesai/{id}', [App\Http\Controllers\Api\PermohonanController::class, 'selesai']);
        Route::post('permohonan/pindah_tugas/{id}', [App\Http\Controllers\Api\PermohonanController::class, 'pindahTugas']);
        Route::post('permohonan/tolak/{id}', [App\Http\Controllers\Api\PermohonanController::class, 'tolak']);
        Route::post('permohonan/teruskan/{id}', [App\Http\Controllers\Api\PermohonanController::class, 'teruskan']);
        Route::get('permohonan/print/{id}', [App\Http\Controllers\Api\PermohonanController::class, 'print']);
        Route::get('permohonan/all', [App\Http\Controllers\Api\PermohonanController::class, 'getAll']);
        Route::apiResource('permohonan', App\Http\Controllers\Api\PermohonanController::class, [
            'names' => [
                'index' => 'permohonan.api.index',
                'store' => 'permohonan.api.store',
                'show' => 'permohonan.api.show',
                'update' => 'permohonan.api.update',
                'destroy' => 'permohonan.api.destroy',
            ]
        ]);


        Route::get('/profile', [App\Http\Controllers\Api\AuthController::class, 'profile']);

    });

});
