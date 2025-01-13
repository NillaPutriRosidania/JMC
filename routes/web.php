<?php

use App\Http\Controllers\AKBController;
use App\Http\Controllers\AKIController;
use App\Http\Controllers\KMeansAKBController;
use App\Http\Controllers\KMeansAKIController;
use App\Http\Controllers\PuskesmasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\TahunController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'show']);

Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store'])->name('register.store');
Route::get('forgot-password', [AuthController::class, 'edit'])->name('forgot');

// Route::get('/api/kecamatan', [MapsController::class, 'getKecamatanData']);
Route::get('/api/kecamatan/{type}', [MapsController::class, 'getKecamatanData']);

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('puskesmas', PuskesmasController::class);
    Route::resource('tahun', TahunController::class);
    Route::resource('aki', AKIController::class);
    Route::resource('akb', AKBController::class);
    Route::resource('kmeans_aki', KMeansAKIController::class);
    Route::resource('kmeans_akb', KMeansAKBController::class);
    Route::get('logout', [AuthController::class, 'destroy'])->name('logout');
});
