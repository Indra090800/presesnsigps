<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\IzinAbsen;
use App\Http\Controllers\Izincuti;
use App\Http\Controllers\IzinSakit;
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

    Route::get('/izinabsen', [IzinAbsen::class, 'index']);
    Route::post('/izinabsen/create', [IzinAbsen::class, 'create']);
    Route::get('/izinabsen/{id_izin}/edit', [IzinAbsen::class, 'vEdit']);
    Route::post('/izinabsen/{id_izin}/fedit', [IzinAbsen::class, 'fEdit']);

    Route::get('/izinsakit', [IzinSakit::class, 'index']);
    Route::post('/izinsakit/create', [IzinSakit::class, 'create']);
    Route::get('/izinsakit/{id_izin}/edit', [IzinSakit::class, 'vEdit']);
    Route::post('/izinsakit/{id_izin}/fedit', [IzinSakit::class, 'fEdit']);

    Route::get('/izincuti', [Izincuti::class, 'index']);
    Route::post('/izincuti/create', [Izincuti::class, 'create']);
    Route::get('/izincuti/{id_izin}/edit', [Izincuti::class, 'vEdit']);
    Route::post('/izincuti/{id_izin}/fedit', [Izincuti::class, 'fEdit']);

    Route::get('/izin/{kode_izin}/showact', [PresensiController::class, 'showact']);
    Route::post('/deleteizin/{id_izin}', [PresensiController::class, 'showact']);
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

    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/addcabang', [CabangController::class, 'addcabang']);
    Route::post('/cabang/{nik}/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/{nik}/delete', [CabangController::class, 'delete']);

    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/addcuti', [CutiController::class, 'addcuti']);
    Route::post('/cuti/{nik}/edit', [CutiController::class, 'edit']);
    Route::post('/cuti/{nik}/delete', [CutiController::class, 'delete']);

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

    Route::get('/configurasi/jam-kerja', [KonfigurasiController::class, 'jam_kerja']);
    Route::post('/addjamKerja', [KonfigurasiController::class, 'addjamKerja']);
    Route::post('/jamKerja/{kode_jamKerja}/edit', [KonfigurasiController::class, 'edit']);
    Route::post('/jamKerja/{kode_jamKerja}/delete', [KonfigurasiController::class, 'delete']);
    Route::get('/konfig/{nik}/setjamkerja', [KonfigurasiController::class, 'setJamKerja']);
    Route::post('/konfig/setJamKaryawan', [KonfigurasiController::class, 'setJamKaryawan']);
    Route::post('/konfig/editsetJamKaryawan', [KonfigurasiController::class, 'editsetJamKaryawan']);

    Route::get('/configurasi/jam-kerjaDep', [KonfigurasiController::class, 'jam_kerjaDep']);
    Route::get('/konfig/jamKerjaDept/create', [KonfigurasiController::class, 'createJkDept']);
    Route::post('/konfig/jamKerjaDept/createJkDept', [KonfigurasiController::class, 'createJkDept1']);
    Route::get('/konfig/jamKerjaDept/{kode_jk_dept}/edit', [KonfigurasiController::class, 'vEdit']);
    Route::post('/konfig/jamKerjaDept/{kode_jk_dept}/editJkDept', [KonfigurasiController::class, 'editJkDept']);
    Route::post('/konfig/jamKerjaDept/{kode_jk_dept}/deleteJkDept', [KonfigurasiController::class, 'deleteJkDept']);
});

