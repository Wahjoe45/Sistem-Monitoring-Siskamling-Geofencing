<?php

use App\Http\Controllers\CheckpointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardWargaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

//Fitur Register
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// Dashboard Pengurus
Route::middleware(['auth', 'checkrole:pengurus'])
    ->get('/pengurus', [DashboardController::class, 'viewpengurus'])
    ->name('pengurus.viewpengurus');

//Dashboard Warga
Route::middleware(['auth', 'checkrole:warga'])
    ->get('/warga', [DashboardWargaController::class, 'viewwarga'])
    ->name('warga.viewwarga');

//olah data pos jaga
Route::resource('posjaga', \App\Http\Controllers\PosjagaController::class);

//olah data laporan
Route::resource('laporan', \App\Http\Controllers\LaporanController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])
        ->name('jadwal.index');
    Route::get('/jadwalwarga', [JadwalController::class, 'jadwalwarga'])
        ->name('jadwal.jadwalwarga');

    Route::middleware(['checkrole:pengurus'])->group(function () {
        Route::post('/jadwal/acak', [JadwalController::class, 'acak'])
            ->name('jadwal.acak');
        Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])
            ->name('jadwal.destroy');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkpoint',
        [CheckpointController::class, 'index']
    )->name('checkpoint.index');

    Route::get('/checkpoint/{id}',
        [CheckpointController::class, 'show']
    )->name('checkpoint.show');

    Route::post('/checkpoint/store',
        [CheckpointController::class, 'store']
    )->name('checkpoint.store');

    Route::get('/riwayat-checkpoint',
        [CheckpointController::class, 'riwayat']
    )->name('checkpoint.riwayat');
});

