<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $query = Cabang::query();
        $query->select('*');
        if(!empty($request->nama_cabang)){
            $query->where('nama_cabang', 'like', '%'. $request->nama_cabang.'%');
        }
        $cabang = $query->get();


        return view('cabang.index', compact( 'cabang'));
    }

    public function addcabang(Request $request)
    {

        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $alamat_cabang = $request->alamat_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;
        $kontak = $request->kontak;
        
        try {
            $data = [
                'kode_cabang'   => $kode_cabang,
                'nama_cabang'   => $nama_cabang,
                'alamat_cabang' => $alamat_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang,
                'kontak'        => $kontak,
            ];
            $simpan = DB::table('tbl_cabang')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Kode cabang = ".$kode_cabang." Sudah Ada!!";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!!'. $message]);
        }
    }

    public function edit($kode_cabang, Request $request)
    {
        $nama_cabang = $request->nama_cabang;
        $alamat_cabang = $request->alamat_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;
        $kontak = $request->kontak;

        try {
            $data = [
                'nama_cabang'   => $nama_cabang,
                'alamat_cabang' => $alamat_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang,
                'kontak'        => $kontak,
            ];
            $update = DB::table('tbl_cabang')->where('kode_cabang', $kode_cabang)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($kode_cabang)
    {
        $delete = DB::table('tbl_cabang')->where('kode_cabang', $kode_cabang)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']); 
        }
    }
}
