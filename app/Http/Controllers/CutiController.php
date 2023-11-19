<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $query = Cuti::query();
        $query->select('*');
        if(!empty($request->nama_cuti)){
            $query->where('nama_cuti', 'like', '%'. $request->nama_cuti.'%');
        }
        $cuti = $query->get();


        return view('cuti.index', compact( 'cuti'));
    }

    public function addcuti(Request $request)
    {

        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        try {
            $data = [
                'kode_cuti'   => $kode_cuti,
                'nama_cuti'   => $nama_cuti,
                'jml_hari'    => $jml_hari,
            ];
            $simpan = DB::table('tbl_cuti')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Kode cuti = ".$kode_cuti." Sudah Ada!!";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!!'. $message]);
        }
    }

    public function edit($kode_cuti, Request $request)
    {
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        try {
            $data = [
                'nama_cuti'   => $nama_cuti,
                'jml_hari'    => $jml_hari,
            ];
            $update = DB::table('tbl_cuti')->where('kode_cuti', $kode_cuti)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($kode_cuti)
    {
        $delete = DB::table('tbl_cuti')->where('kode_cuti', $kode_cuti)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
