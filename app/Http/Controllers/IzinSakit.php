<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinSakit extends Controller
{
    public function index()
    {
        return view('absen.izinsakit');
    }

    public function create(Request $request)
    {

        $dari = $request->tgl_izin_dari;
        $sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $nik = Auth::guard('karyawan')->user()->nik;
        $status = $request->status;
        $sid = $request->sid;

        if ($request->hasFile('sid')) {
            $sid = "sid-" . $nik . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = null;
        }

        $bulan = date("m", strtotime($dari));
        $tahun = date("Y", strtotime($dari));

        $lastizin = DB::table('tbl_pengajuan')
            ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
            ->orderBy('id_izin', 'desc')
            ->first();

        $lastkodeizin = $lastizin != null ? $lastizin->id_izin : "";
        $format = "IS" . $bulan . $tahun;
        $kodeizin = buatkode($lastkodeizin, $format, 3);

        $data = [
            'id_izin'         => $kodeizin,
            'nik'             => $nik,
            'tgl_izin_dari'   => $dari,
            'tgl_izin_sampai' => $sampai,
            'status'          => $status,
            'keterangan'      => $keterangan,
            'sid'             => $sid,
            'status_approved' => 0
        ];
        $izin = DB::table('tbl_pengajuan')->insert($data);

        if ($izin) {
            if ($request->hasFile('sid')) {
                $sid = "sid-" . $nik . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
            }
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Ajukan!!']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Ajukan!!']);;
        }
    }

    public function vEdit($id_izin)
    {
        $is = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->first();
        return view('absen.visEdit', compact('is'));
    }

    public function fEdit(Request $request, $id_izin)
    {
        $dari = $request->tgl_izin_dari;
        $sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $nik = Auth::guard('karyawan')->user()->nik;
        $status = $request->status;
        $kode_cuti = $request->kode_cuti;

        $data = [
            'nik'             => $nik,
            'tgl_izin_dari'   => $dari,
            'tgl_izin_sampai' => $sampai,
            'status'          => $status,
            'keterangan'      => $keterangan,
            'kode_cuti'       => $kode_cuti,
            'status_approved' => 0
        ];
        $izin = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update($data);

        if ($izin) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Edit!!']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Edit!!']);;
        }
    }
}
