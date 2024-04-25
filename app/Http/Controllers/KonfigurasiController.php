<?php

namespace App\Http\Controllers;

use App\Models\JkDept;
use App\Models\SetJamKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasi_kantor()
    {
        $lok_kantor = DB::table('config_lokasi')->where('id', 1)->first();
        return view('configurasi.lokasi', compact('lok_kantor'));
    }

    public function updatelokasi(Request $request)
    {
        $lokasi = $request->lokasi;
        $radius = $request->radius;

        $data = [
            'lokasi' => $lokasi,
            'radius' => $radius
        ];

        $update = DB::table('config_lokasi')->where('id',1)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update!!']);
        }
    }
    public function jam_kerja()
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('kode_jamKerja')->get();
        return view('configurasi.jam', compact('jam_kerja'));
    }

    public function addjamKerja(Request $request)
    {

        $kode_jamKerja = $request->kode_jamKerja;
        $nama_jamKerja = $request->nama_jamKerja;
        $awal_jam_in = $request->awal_jam_in;
        $jam_in = $request->jam_in;
        $akhir_jam_in = $request->akhir_jam_in;
        $jam_pulang = $request->jam_pulang;

        try {
            $data = [
                'kode_jamKerja'   => $kode_jamKerja,
                'nama_jamKerja'   => $nama_jamKerja,
                'awal_jam_in'     => $awal_jam_in,
                'jam_masuk'       => $jam_in,
                'akhir_jam_in'    => $akhir_jam_in,
                'jam_pulang'      => $jam_pulang,
            ];
            $simpan = DB::table('jam_kerja')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Kode cabang = ".$kode_jamKerja." Sudah Ada!!";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!!'. $message]);
        }
    }

    public function edit($kode_jamKerja, Request $request)
    {
        $nama_jamKerja = $request->nama_jamKerja;
        $awal_jam_in = $request->awal_jam_in;
        $jam_in = $request->jam_in;
        $akhir_jam_in = $request->akhir_jam_in;
        $jam_pulang = $request->jam_pulang;

        try {
            $data = [
                'kode_jamKerja'   => $kode_jamKerja,
                'nama_jamKerja'   => $nama_jamKerja,
                'awal_jam_in'     => $awal_jam_in,
                'jam_masuk'       => $jam_in,
                'akhir_jam_in'    => $akhir_jam_in,
                'jam_pulang'      => $jam_pulang,
            ];
            $update = DB::table('jam_kerja')->where('kode_jamKerja', $kode_jamKerja)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($kode_jamKerja)
    {
        $delete = DB::table('jam_kerja')->where('kode_jamKerja', $kode_jamKerja)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function setJamKerja($nik){
        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)->first();
        $jam = DB::table('jam_kerja')->orderBy('nama_jamKerja')->get();

        $cek = DB::table('set_jamKerja')->where('nik', $nik)->count();

        if($cek > 0){
            $setjam = DB::table('set_jamKerja')
            ->join('jam_kerja', 'set_jamKerja.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
            ->where('nik', $nik)->get();
            return view('configurasi.editsetjam', compact('karyawan', 'jam', 'cek', 'setjam'));
        }else{
            return view('configurasi.setjam', compact('karyawan', 'jam', 'cek'));
        }
    }

    public function setJamKaryawan(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamKerja = $request->kode_jamKerja;

        for ($i=0; $i < count($hari); $i++) {
            $data[] = [
                'nik'             => $nik,
                'hari'            => $hari[$i],
                'kode_jamKerja'   => $kode_jamKerja[$i],
            ];
        }

        try {
            SetJamKerja::insert($data);
            return Redirect('/karyawan')->with(['success' => 'Data Jam Kerja Berhasil Di Simpan!!']);
        } catch (\Exception $e) {
            return Redirect('/karyawan')->with(['error' => 'Data Jam Kerja Gagal Di Simpan!!']);
        }
    }

    public function editsetJamKaryawan(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamKerja = $request->kode_jamKerja;

        for ($i=0; $i < count($hari); $i++) {
            $data[] = [
                'nik'             => $nik,
                'hari'            => $hari[$i],
                'kode_jamKerja'   => $kode_jamKerja[$i],
            ];
        }
        dd($hari);

        DB::beginTransaction();
        try {
            DB::table('set_jamKerja')->where('nik', $nik)->delete();
            SetJamKerja::insert($data);
            DB::commit();
            return Redirect('/karyawan')->with(['success' => 'Data Jam Kerja Berhasil Di Update!!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect('/karyawan')->with(['error' => 'Data Jam Kerja Gagal Di Simpan!!']);
        }
    }

    public function jam_kerjaDep(){
        $jkdept = DB::table('jk_dept')
        ->join('tbl_cabang', 'jk_dept.kode_cabang', '=', 'tbl_cabang.kode_cabang')
        ->join('tbl_dept', 'jk_dept.kode_dept', '=', 'tbl_dept.kode_dept')
        ->orderBy('kode_jk_dept')->get();
        $jam = DB::table('jam_kerja')->orderBy('nama_jamKerja')->get();

        return view('configurasi.jamKerjaDep', compact('jkdept','jam'));
    }

    public function createJkDept(){
        $jam = DB::table('jam_kerja')->orderBy('nama_jamKerja')->get();
        $kode_cabang = DB::table('tbl_cabang')->get();
        $kode_dept = DB::table('tbl_dept')->get();
        $set = DB::table('jk_dept')
        ->join('tbl_cabang', 'jk_dept.kode_cabang', '=', 'tbl_cabang.kode_cabang')
        ->join('tbl_dept', 'jk_dept.kode_dept', '=', 'tbl_dept.kode_dept')
        ->get();
        $setjam = DB::table('jk_dept_detail')
        ->join('jam_kerja', 'jk_dept_detail.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
        ->get();

        return view('configurasi.createjamKerjaDep', compact('jam', 'kode_cabang', 'kode_dept'));
    }

    public function createJkDept1(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jamKerja = $request->kode_jamKerja;
        $kode_jk_dept = "J".$kode_cabang.$kode_dept;

        DB::beginTransaction();
        try {
            DB::table('jk_dept')->insert([
                'kode_jk_dept'    => $kode_jk_dept,
                'kode_cabang'     => $kode_cabang,
                'kode_dept'       => $kode_dept,
            ]);
            for ($i=0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept'    => $kode_jk_dept,
                    'hari'            => $hari[$i],
                    'kode_jamKerja'   => $kode_jamKerja[$i],
                ];
            }
            JkDept::insert($data);
            DB::commit();
            return Redirect('/configurasi/jam-kerjaDep')->with(['success' => 'Data Jam Kerja Departemen Berhasil Di Simpan!!']);
        } catch (\Exception $e) {
            DB::rollBack();
            if($e->getCode()==23000){
                $message = "Data Cabang dengan departemen ini sudah ada!!";
            }else {
                $message = "Hubungi Tim IT";
            }
            return Redirect('/configurasi/jam-kerjaDep')->with(['error' => $message]);
        }
    }

    public function vEdit($kode_jk_dept){
        $jam = DB::table('jam_kerja')->orderBy('nama_jamKerja')->get();
        $kode_cabang = DB::table('tbl_cabang')->get();
        $kode_dept = DB::table('tbl_dept')->get();
        $set = DB::table('jk_dept')
        ->join('tbl_cabang', 'jk_dept.kode_cabang', '=', 'tbl_cabang.kode_cabang')
        ->join('tbl_dept', 'jk_dept.kode_dept', '=', 'tbl_dept.kode_dept')
        ->where('kode_jk_dept', $kode_jk_dept)
        ->first();
        $setjam = DB::table('jk_dept_detail')
        ->join('jam_kerja', 'jk_dept_detail.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
        ->where('kode_jk_dept', $kode_jk_dept)
        ->get();

        return view('configurasi.veditJKDept', compact('jam', 'kode_cabang', 'kode_dept', 'setjam', 'set'));
    }

    public function editJkDept(Request $request, $kode_jk_dept){
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jamKerja = $request->kode_jamKerja;

        DB::beginTransaction();
        try {
            DB::table('jk_dept')->where('kode_jk_dept',$kode_jk_dept)->update([
                'kode_cabang'     => $kode_cabang,
                'kode_dept'       => $kode_dept,
            ]);
            for ($i=0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept'    => $kode_jk_dept,
                    'hari'            => $hari[$i],
                    'kode_jamKerja'   => $kode_jamKerja[$i],
                ];
            }
            DB::table('jk_dept_detail')->where('kode_jk_dept',$kode_jk_dept)->delete();
            JkDept::insert($data);
            DB::commit();
            return Redirect('/configurasi/jam-kerjaDep')->with(['success' => 'Data Jam Kerja Departemen Berhasil Di Update!!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect('/configurasi/jam-kerjaDep')->with(['error' => 'Data Jam Kerja Departemen Gagal Di Update!!']);
        }
    }

    public function deleteJkDept($kode_jk_dept){
        $delete = DB::table('jk_dept')->where('kode_jk_dept',$kode_jk_dept)->delete();
        if($delete){
            DB::table('jk_dept_detail')->where('kode_jk_dept',$kode_jk_dept)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
