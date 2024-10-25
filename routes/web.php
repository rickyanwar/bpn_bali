<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggabunganController;
use App\Http\Controllers\PemecahanController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\ReportController;

// Route::get('/', function () {
//     return redirect('/login');
// });

Auth::routes();



Route::get('display/', [DashboardController::class, 'display'])->name('dashboard.display');
Route::get('display/get-list', [DashboardController::class, 'getListdisplay'])->name('dashboard.get.list');
Route::get('display/pemohon_hari_ini', [DashboardController::class, 'getPemohonToday'])->name('dashboard.pemohon_today');




Route::get('/', function () {
    return redirect('/login');
});


// Group routes that need authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);


    Route::get('audit-trails', [AuditTrailController::class, 'index'])->name('audit.index');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('permohonan/detail/{id}', [PermohonanController::class, 'detail'])->name('permohonan.detail');
    Route::get('permohonan/audit-trails/{id}', [PermohonanController::class, 'auditTrails'])->name('permohonan.audit-trails');
    Route::get('permohonan/riwayat-penerusan/{id}', [PermohonanController::class, 'riwayatDiteruskan'])->name('permohonan.riwayat-penerusan');
    Route::post('permohonan/tolak/{id}', [PermohonanController::class, 'tolak'])->name('permohonan.tolak');
    Route::post('permohonan/selesai/{id}', [PermohonanController::class, 'selesai'])->name('permohonan.selesai');
    Route::post('permohonan/teruskan/{id}', [PermohonanController::class, 'teruskan'])->name('permohonan.teruskan');
    Route::get('permohonan/print/{id}', [PermohonanController::class, 'print'])->name('permohonan.print');

    Route::post('permohonan/ambil_tugas/{id}', [PermohonanController::class, 'ambilTugas'])->name('permohonan.ambil_tugas');
    Route::get('permohonan/print/pemberitahuan/{id}', [PermohonanController::class, 'printPemberitahuan'])->name('permohonan.print.pemberitahuan');
    Route::get('permohonan/print-view/{id}', [PermohonanController::class, 'printView'])->name('permohonan.print_view');
    Route::post('permohonan/pindah_tugas/{id}', [PermohonanController::class, 'pindahTugas'])->name('permohonan.pindah_tugas');
    Route::get('permohonan/teruskan_view/{id}', [PermohonanController::class, 'teruskanView'])->name('permohonan.teruskan_view');
    Route::get('permohonan/get-all', [PermohonanController::class, 'getAll'])->name('permohonan.all');
    Route::resource('permohonan', PermohonanController::class);

    //Report
    Route::get('report/jadwal_pengukuran', [ReportController::class, 'jadwalPengukuran'])->name('report.jadwal_pengukuran');
    Route::get('report/setor_berkas', [ReportController::class, 'jadwalSetorBerkas'])->name('report.setor_berkas');

    // User password reset routes
    Route::any('user-reset-password/{id}', [UserController::class, 'userPassword'])->name('users.reset');
    Route::post('user-reset-password/{id}', [UserController::class, 'userPasswordReset'])->name('user.password.update');
});
