<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $query = Departemen::query();
        $query->select('*');
        if(!empty($request->nama_dept)){
            $query->where('nama_dept', 'like', '%'. $request->nama_dept.'%');
        }
        $dept = $query->get();


        return view('departemen.index', compact( 'dept'));
    }

    public function adddept(Request $request)
    {

        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        
        try {
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept,
            ];
            $simpan = DB::table('tbl_dept')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!!']);
        }
    }

    public function edit($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;

        try {
            $data = [
                'nama_dept' => $nama_dept,
            ];
            $update = DB::table('tbl_dept')->where('kode_dept', $kode_dept)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($kode_dept)
    {
        $delete = DB::table('tbl_dept')->where('kode_dept', $kode_dept)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']); 
        }
    }
}
