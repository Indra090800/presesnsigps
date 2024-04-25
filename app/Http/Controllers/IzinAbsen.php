<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinAbsen extends Controller
{
    public function index(){
        return view('absen.izinabsen');
    }

    public function create(Request $request){
        $dari = $request->tgl_izin_dari;
        $sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $nik = Auth::guard('karyawan')->user()->nik;
        $status = $request->status;

        $bulan = date("m", strtotime($dari));
        $tahun = date("Y", strtotime($dari));

        $lastizin = DB::table('tbl_pengajuan')
        ->whereRaw('MONTH(tgl_izin_dari)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_izin_dari)="'.$tahun.'"')
        ->orderBy('id_izin', 'desc')
        ->first();

        $lastkodeizin = $lastizin != null ? $lastizin->id_izin : "";
        $format = "IZ".$bulan.$tahun;
        $kodeizin = buatkode($lastkodeizin, $format, 3);
        $data = [
            'id_izin'         => $kodeizin,
            'nik'             => $nik,
            'tgl_izin_dari'   => $dari,
            'tgl_izin_sampai' => $sampai,
            'status'          => $status,
            'keterangan'      => $keterangan,
            'status_approved' => 0
        ];
        $izin = DB::table('tbl_pengajuan')->insert($data);

        if($izin){
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Ajukan!!']);
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Ajukan!!']);;
        }
    }

    public function vEdit($id_izin){
        $izin = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->first();
        return view('absen.viEdit', compact('izin'));
    }

    public function fEdit(Request $request, $id_izin){
        $dari = $request->tgl_izin_dari;
        $sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $nik = Auth::guard('karyawan')->user()->nik;
        $status = $request->status;
        $data = [
            'nik'             => $nik,
            'tgl_izin_dari'   => $dari,
            'tgl_izin_sampai' => $sampai,
            'status'          => $status,
            'keterangan'      => $keterangan,
            'status_approved' => 0
        ];
        $izin = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update($data);

        if($izin){
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Simpan!!']);
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Simpan!!']);;
        }
    }
}
