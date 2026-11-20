<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardWargaController;
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

Route::get('/dashboard/pengurus', [DashboardController::class, 'viewpengurus'])
    ->name('pengurus.viewpengurus');
