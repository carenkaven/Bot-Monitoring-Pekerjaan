<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Auth\RegisterKaryawanController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Admin\WeeklyReportController;
use App\Http\Controllers\WeeklyPdfController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\LaporanController as KaryawanLaporanController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.landing')->name('landing');

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register-karyawan', [RegisterKaryawanController::class, 'create'])
        ->name('register.karyawan');

    Route::post('/register-karyawan', [RegisterKaryawanController::class, 'store'])
        ->name('register.karyawan.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Semua route di bawah ini hanya bisa diakses oleh user dengan role "admin".
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* Karyawan */
    Route::resource('karyawan', KaryawanController::class)->except(['show']);
    Route::patch('/karyawan/{karyawan}/approve', [KaryawanController::class, 'approve'])->name('karyawan.approve');
    Route::patch('/karyawan/{karyawan}/reject', [KaryawanController::class, 'reject'])->name('karyawan.reject');
    Route::patch('/karyawan/{karyawan}/nonaktif', [KaryawanController::class, 'nonaktif'])->name('karyawan.nonaktif');

    /* Monitoring Laporan */
    Route::resource('laporan', LaporanController::class);

    /*
    |--------------------------------------------------------------------------
    | Monitoring Laporan Mingguan
    |--------------------------------------------------------------------------
    */

    Route::prefix('weekly')
        ->name('weekly.')
        ->group(function () {

            Route::get('/', [WeeklyReportController::class, 'index'])->name('index');

            Route::get('/{minggu}/{proyek}', [WeeklyReportController::class, 'show'])->name('show');

        });

    /* Verifikasi */
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        Route::get('/riwayat', [VerifikasiController::class, 'riwayat'])->name('riwayat');
        Route::get('/{laporan}', [VerifikasiController::class, 'show'])->name('show');
        Route::patch('/{laporan}/setujui', [VerifikasiController::class, 'setujui'])->name('setujui');
        Route::patch('/{laporan}/tolak', [VerifikasiController::class, 'tolak'])->name('tolak');
    });

    /* PDF */
    Route::get('/pdf/harian/{laporan}', [PdfController::class, 'harian'])->name('pdf.harian');

    Route::get('/pdf/weekly/{minggu}/{proyek}', [WeeklyPdfController::class, 'weekly'])->name('pdf.weekly');

});

/*
|--------------------------------------------------------------------------
| KARYAWAN
|--------------------------------------------------------------------------
| Semua route di bawah ini hanya bisa diakses oleh user dengan role
| "karyawan" yang akunnya sudah aktif & terverifikasi oleh admin.
*/

Route::middleware(['auth', 'karyawan'])->group(function () {

    Route::get('/dashboard-karyawan', [KaryawanDashboardController::class, 'index'])
        ->name('dashboard.karyawan');

    Route::get('/laporan-saya', [KaryawanLaporanController::class, 'index'])
        ->name('laporan-saya.index');

    Route::get('/laporan-saya/{laporan}', [KaryawanLaporanController::class, 'show'])
        ->name('laporan-saya.show');

});

/*
|--------------------------------------------------------------------------
| SHARED (admin & karyawan)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::get('/wa-qr', function () {
    $qrPath = storage_path('app/whatsapp-qr.txt');
    $qr = file_exists($qrPath) ? file_get_contents($qrPath) : null;
    return view('pages.wa-qr', compact('qr'));
});

require __DIR__ . '/auth.php';
