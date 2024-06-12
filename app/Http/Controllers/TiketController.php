<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class TiketController extends Controller
{
    public function index()
    {
        return view('tiket.tiket');
    }
    public function validasi(Request $request)
    {
        $qr = $request->qr_code;
    }

    public function tukarkan_kupon(Request $request)
    {

        $kode_kupon = $request->result;
        $nama = $request->nama;

        try {
            $data = [
                'kode_kupon' => $kode_kupon,
                'nama' => $nama,
            ];
            $simpan = DB::table('tbl_tiket')->insert($data);
        if($simpan){
            Alert::success('Hore!', 'Kupon Berhasil Ditukarkan!!');
            return Redirect('/ticket_qurban');
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Kode Kupon = ".$kode_kupon." Sudah Ditukarkan!!";
            }
            Alert::error('Upss!', $message);
            return Redirect('/ticket_qurban');
        }
    }
}
