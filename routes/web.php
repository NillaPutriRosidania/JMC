<?php
use App\Http\Controllers\AKBController;
use App\Http\Controllers\AKIController;
use App\Http\Controllers\KMeansAKBController;
use App\Http\Controllers\KMeansAKIController;
use App\Http\Controllers\KMeansAKI3Controller;
use App\Http\Controllers\KMeansAKB3Controller;
use App\Http\Controllers\KMeansAKI4Controller;
use App\Http\Controllers\KMeansAKB4Controller;
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
Route::get('/api/kecamatan/{type}', [MapsController::class, 'getKecamatanData']);

// Rute yang dapat diakses tanpa login (tanpa middleware auth)
Route::resource('kmeans_aki', KMeansAKIController::class);
Route::resource('kmeans_akb', KMeansAKBController::class);
Route::resource('kmeans_aki3', KMeansAKI3Controller::class);
Route::resource('kmeans_akb3', KMeansAKB3Controller::class);
Route::resource('kmeans_aki4', KMeansAKI4Controller::class);
Route::resource('kmeans_akb4', KMeansAKB4Controller::class);

// Grup middleware 'auth' untuk rute yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('puskesmas', PuskesmasController::class);
    Route::resource('tahun', TahunController::class);
    Route::resource('aki', AKIController::class);
    Route::resource('akb', AKBController::class);
    Route::get('/api/charts/{type}/{puskesmasId}', [DashboardController::class, 'getChartData']);
    Route::get('logout', [AuthController::class, 'destroy'])->name('logout');
});