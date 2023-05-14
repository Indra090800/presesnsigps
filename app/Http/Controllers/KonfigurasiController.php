<?php

namespace App\Http\Controllers;

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
}
