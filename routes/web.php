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
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\TahunController;
use App\Models\Berita;

Route::get('/', function () {
    $latestNews = Berita::latest()->paginate(5);
    $mapData = (new MapsController)->getKecamatanData();
    return view('welcome', compact('latestNews', 'mapData'));
});


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'show']);

Route::get('register', [AuthController::class, 'create'])->name('register');
Route::post('register', [AuthController::class, 'store'])->name('register.store');
Route::get('forgot-password', [AuthController::class, 'edit'])->name('forgot');
Route::get('/api/kecamatan/{type}', [MapsController::class, 'getKecamatanData']);
Route::resource('kmeans_aki', KMeansAKIController::class);
Route::resource('kmeans_akb', KMeansAKBController::class);
Route::resource('kmeans_aki3', KMeansAKI3Controller::class);
Route::resource('kmeans_akb3', KMeansAKB3Controller::class);
Route::resource('kmeans_aki4', KMeansAKI4Controller::class);
Route::resource('kmeans_akb4', KMeansAKB4Controller::class);
Route::get('berita/{id}', [BeritaController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('berita.show');

Route::middleware('auth')->group(function () {
    Route::get('berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('puskesmas', PuskesmasController::class);
    Route::resource('tahun', TahunController::class);
    Route::resource('aki', AKIController::class);
    Route::resource('akb', AKBController::class);
    Route::get('/api/charts/{type}/{puskesmasId}', [DashboardController::class, 'getChartData']);
    Route::get('logout', [AuthController::class, 'destroy'])->name('logout');

    //export
    Route::get('/export/kmeans-akb', [KMeansAKBController::class, 'exportData'])->name('export.kmeans.akb');
    Route::get('/export/kmeans-akb3', [KMeansAKB3Controller::class, 'exportData'])->name('export.kmeans.akb3');
    Route::get('/export/kmeans-akb4', [KMeansAKB4Controller::class, 'exportData'])->name('export.kmeans.akb4');
    Route::get('/export/kmeans-aki', [KMeansAKIController::class, 'exportData'])->name('export.kmeans.aki');
    Route::get('/export/kmeans-aki3', [KMeansAKI3Controller::class, 'exportData'])->name('export.kmeans.aki3');
    Route::get('/export/kmeans-aki4', [KMeansAKI4Controller::class, 'exportData'])->name('export.kmeans.aki4');
});