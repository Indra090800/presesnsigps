<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest:karyawan'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/loginadmin', [AuthController::class, 'loginadmin']);
});


Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //presensi
    Route::get('/presensi/create', [PresensiController::class, 'index']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    //izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);

    Route::post('/presensi/cekpengajuan', [PresensiController::class, 'cekpengajuan']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/addKaryawan', [KaryawanController::class, 'addKaryawan']);
    Route::post('/karyawan/{nik}/edit', [KaryawanController::class, 'editKaryawan']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/adddept', [DepartemenController::class, 'adddept']);
    Route::post('/dept/{nik}/edit', [DepartemenController::class, 'edit']);
    Route::post('/dept/{nik}/delete', [DepartemenController::class, 'delete']);

    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilpeta', [PresensiController::class, 'tampilpeta']);

    Route::get('/presensi/laporan-presensi', [PresensiController::class, 'laporanpresensi']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);

    Route::get('/presensi/rekap-presensi', [PresensiController::class, 'rekappresensi']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);

    Route::get('/presensi/datapengajuan', [PresensiController::class, 'datapengajuan']);
    Route::post('/presensi/uppengajuan/{id_izin}', [PresensiController::class, 'uppengajuan']);
    Route::get('/batalkan/{id_izin}', [PresensiController::class, 'batalkan']);

    Route::get('/configurasi/lokasi-kantor', [KonfigurasiController::class, 'lokasi_kantor']);
    Route::post('/configurasi/updatelokasi', [KonfigurasiController::class, 'updatelokasi']);
});

