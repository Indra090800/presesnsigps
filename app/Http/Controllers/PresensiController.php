<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('tbl_presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $lokasi_kantor = DB::table('config_lokasi')->where('id',1)->first();
        return view('presensi.create', compact('cek', 'lokasi_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi_kantor = DB::table('config_lokasi')->where('id',1)->first();
        $lok = explode(",", $lokasi_kantor->lokasi);
        $latitudekantor = $lok[0];  
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitudeuser = $lokasi_user[0];
        $longitudeuser = $lokasi_user[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('tbl_presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if($cek > 0){
            $ket = "out";
        }else{
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik."-".$tgl_presensi."-".$ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
         
        if($radius > $lokasi_kantor->radius){
            echo "error|Maaf, Anda diluar jangkauan radius ".$radius."meter dari kantor|radius";
        }else{
            if($cek > 0){
                $data_pulang = [
                    'jam_out'       => $jam,
                    'foto_out'      => $fileName,
                    'lokasi_out'    => $lokasi
                ]; 
                $update = DB::table('tbl_presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if($update){
                    echo "success|Terima Kasih, Selamat Beristirahat|out";
                    Storage::put($file, $image_base64); 
                }else{
                    echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|out";
                }
            }else{
                $data = [
                    'nik'          => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in'       => $jam,
                    'foto_in'      => $fileName,
                    'lokasi_in'    => $lokasi
                ]; 
                $simpan = DB::table('tbl_presensi')->insert($data);
                if($simpan){
                    echo "success|Terima Kasih, Selamat Gawe, Utamakan Keselamatan Kerja ya|in";
                    Storage::put($file, $image_base64); 
                }else{
                    echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|in";
                }
            }
        }
    }

    //menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)->first();
        $old_foto = $karyawan->foto;

        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }
        if(empty($request->password)){
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp'        => $no_hp,
                'foto'         => $foto
            ];
        }else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp'        => $no_hp,
                'password'     => $password,
                'foto'         => $foto
            ];
        }
        $update = DB::table('tbl_karyawan')->where('nik', $nik)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $folderPathOld = "public/uploads/karyawan/".$old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);;
        }
    }

    public function histori()
    {
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('tbl_presensi')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('nik', $nik)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('tbl_pengajuan')->where('nik', $nik)->get();

        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $status = $request->status;
        $tgl_izin = $request->tgl_izin;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan,
            'status_approved' => 0
        ];
        $izin = DB::table('tbl_pengajuan')->insert($data);

        if($izin){
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Ajukan!!']);
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Ajukan!!']);;
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('tbl_presensi')
        ->select('tbl_presensi.*', 'nama_lengkap', 'nama_dept')
        ->join('tbl_karyawan', 'tbl_presensi.nik', '=', 'tbl_karyawan.nik')
        ->join('tbl_dept', 'tbl_karyawan.kode_dept', '=', 'tbl_dept.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function tampilpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('tbl_presensi')->where('id_presensi', $id)
        ->join('tbl_karyawan', 'tbl_presensi.nik', '=', 'tbl_karyawan.nik')
        ->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporanpresensi()
    {
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('tbl_karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporanpresensi', compact('namabulan','karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik   = $request->nik;
        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)
        ->join('tbl_dept', 'tbl_karyawan.kode_dept', '=', 'tbl_dept.kode_dept')
        ->first();
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        $presensi = DB::table('tbl_presensi')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->orderBy('tgl_presensi')
        ->get();
        return view('presensi.cetaklaporan', compact('bulan','tahun','namabulan', 'karyawan', 'presensi'));
    }

    public function rekappresensi()
    {
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('presensi.rekappresensi', compact('namabulan',));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $rekap = DB::table('tbl_presensi')
        ->selectRaw('tbl_presensi.nik, nama_lengkap,
            MAX(IF(DaY(tgl_presensi) = 1,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_1,
            MAX(IF(DaY(tgl_presensi) = 2,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_2,
            MAX(IF(DaY(tgl_presensi) = 3,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_3,
            MAX(IF(DaY(tgl_presensi) = 4,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_4,
            MAX(IF(DaY(tgl_presensi) = 5,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_5,
            MAX(IF(DaY(tgl_presensi) = 6,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_6,
            MAX(IF(DaY(tgl_presensi) = 7,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_7,
            MAX(IF(DaY(tgl_presensi) = 8,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_8,
            MAX(IF(DaY(tgl_presensi) = 9,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_9,
            MAX(IF(DaY(tgl_presensi) = 10,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_10,
            MAX(IF(DaY(tgl_presensi) = 11,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_11,
            MAX(IF(DaY(tgl_presensi) = 12,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_12,
            MAX(IF(DaY(tgl_presensi) = 13,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_13,
            MAX(IF(DaY(tgl_presensi) = 14,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_14,
            MAX(IF(DaY(tgl_presensi) = 15,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_15,
            MAX(IF(DaY(tgl_presensi) = 16,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_16,
            MAX(IF(DaY(tgl_presensi) = 17,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_17,
            MAX(IF(DaY(tgl_presensi) = 18,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_18,
            MAX(IF(DaY(tgl_presensi) = 19,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_19,
            MAX(IF(DaY(tgl_presensi) = 20,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_20,
            MAX(IF(DaY(tgl_presensi) = 21,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_21,
            MAX(IF(DaY(tgl_presensi) = 22,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_22,
            MAX(IF(DaY(tgl_presensi) = 23,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_23,
            MAX(IF(DaY(tgl_presensi) = 24,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_24,
            MAX(IF(DaY(tgl_presensi) = 25,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_25,
            MAX(IF(DaY(tgl_presensi) = 26,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_26,
            MAX(IF(DaY(tgl_presensi) = 27,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_27,
            MAX(IF(DaY(tgl_presensi) = 28,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_28,
            MAX(IF(DaY(tgl_presensi) = 29,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_29,
            MAX(IF(DaY(tgl_presensi) = 30,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_30,
            MAX(IF(DaY(tgl_presensi) = 31,CONCAT(jam_in, "-", IFNULL(jam_out,"00:00:00")), "")) as tgl_31')
        ->join('tbl_karyawan', 'tbl_presensi.nik', '=', 'tbl_karyawan.nik')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->groupByRaw('tbl_presensi.nik, nama_lengkap')
        ->get();

        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('presensi.rekap', compact('rekap', 'namabulan', 'bulan', 'tahun'));
    }

    public function datapengajuan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $nik = $request->nik;
        $nama = $request->nama_lengkap;
        $status = $request->status_approved;


        $query = Pengajuan::query();
        $query->select('id_izin', 'tgl_izin', 'tbl_pengajuan.nik', 'nama_lengkap', 'jabatan', 'status', 'keterangan', 'status_approved');
        $query->join('tbl_karyawan', 'tbl_pengajuan.nik', '=', 'tbl_karyawan.nik');
        if(!empty($dari) && !empty($sampai)){
         $query->whereBetween('tgl_izin', [$dari, $sampai]);   
        }

        if(!empty($nik)){
            $query->where('tbl_pengajuan.ni', $nik);
        }
        if(!empty($nama)){
            $query->where('nama_lengkap','like','%'. $nama. '%');
        }
        if($status === "0" || $status == '1' || $status == '2'){
            $query->where('status_approved', $status);
        }
        $query->orderBy('tgl_izin', 'desc');
        $pengajuan = $query->paginate(1);
        $pengajuan->appends($request->all());

        $pengajuan_now = DB::table('tbl_pengajuan')
        ->join('tbl_karyawan', 'tbl_pengajuan.nik', '=', 'tbl_karyawan.nik')
        ->where('tgl_izin', date('Y-m-d'))
        ->orderBy('tgl_izin')
        ->get();
        return view('presensi.pengajuan', compact('pengajuan', 'pengajuan_now','dari', 'sampai'));
    }

    public function uppengajuan(Request $request, $id_izin)
    {
        $status = $request->status_approved;
        $update = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update([
            'status_approved' => $status
        ]);

        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate !!']);
        }
    }

    public function batalkan($id_izin)
    {
        $update = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update([
            'status_approved' => 0
        ]);

        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate !!']);
        }
    }

    public function cekpengajuan(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('tbl_pengajuan')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
