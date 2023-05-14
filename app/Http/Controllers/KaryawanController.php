<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->select('tbl_karyawan.*','nama_dept');
        $query->join('tbl_dept', 'tbl_karyawan.kode_dept', '=', 'tbl_dept.kode_dept');
        $query->orderBY('nama_lengkap');
        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap', 'like', '%'. $request->nama_lengkap.'%');
        }
        if(!empty($request->kode_dept)){
            $query->where('tbl_karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(7);


        $dept = DB::table('tbl_dept')->get();
        return view('karyawan.index', compact('karyawan', 'dept'));
    }

    public function addKaryawan(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)->first();

        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        }
        
        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' =>$kode_dept,
                'password' => $password,
                'foto' => $foto
            ];
            $simpan = DB::table('tbl_karyawan')->insert($data);
        if($simpan){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!!']);
        }
    }

    public function editKaryawan($nik, Request $request)
    {
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)->first();
        $old_foto = $karyawan->foto;

        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }
        
        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' =>$kode_dept,
                'password' => $password,
                'foto' => $foto
            ];
            $update = DB::table('tbl_karyawan')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $folderPathOld = "public/uploads/karyawan/".$old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('tbl_karyawan')->where('nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']); 
        }
    }
}
