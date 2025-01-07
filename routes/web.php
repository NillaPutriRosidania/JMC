<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MapsController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'show']);

Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store'])->name('register.store');
Route::get('forgot-password', [AuthController::class, 'edit'])->name('forgot');
Route::get('/api/kecamatan', [MapsController::class, 'getKecamatanData']);
Route::resource('dashboard', DashboardController::class);
Route::resource('kecamatan', KecamatanController::class);
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');
