<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
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
            if ($simpan) {
                Alert::success('Hore!', 'Kupon Berhasil Ditukarkan!!');
                return Redirect('/ticket_qurban');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $message = "Data Kode Kupon = " . $kode_kupon . " Sudah Ditukarkan!!";
            }
            Alert::error('Upss!', $message);
            return Redirect('/ticket_qurban');
        }
    }

    public function admin(Request $request)
    {
        $query = Tiket::query();
        $query->select('*');
        if (!empty($request->kode_kupon)) {
            $query->where('kode_kupon', 'like', '%' . $request->kode_kupon . '%');
        } else if (!empty($request->nama)) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        $kupon = $query->get();


        return view('tiket.index', compact('kupon'));
    }

    public function edit($kode_kupon, Request $request)
    {
        $nama = $request->nama;

        try {
            $data = [
                'nama' => $nama,
            ];
            $update = DB::table('tbl_tiket')->where('kode_kupon', $kode_kupon)->update($data);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($kode_kupon)
    {
        $delete = DB::table('tbl_tiket')->where('kode_kupon', $kode_kupon)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
