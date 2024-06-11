<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
