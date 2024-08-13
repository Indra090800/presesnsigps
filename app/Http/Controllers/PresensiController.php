<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function gethari()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "Kamis";
                break;
            case 'Fri':
                $hari_ini = "Jumat";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;
            default:
                # code...
                break;
        }
        return $hari_ini;
    }

    public function index()
    {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_dept = Auth::guard('karyawan')->user()->kode_dept;
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $cek = DB::table('tbl_presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $lokasi_kantor = DB::table('tbl_cabang')->where('kode_cabang', $kode_cabang)->first();

        $jamkerja = DB::table('set_jamKerja')
            ->join('jam_kerja', 'set_jamKerja.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
            ->where('nik', $nik)->where('hari', $namahari)->first();

        if ($jamkerja == null) {
            $jamkerja = DB::table('jk_dept_detail')
                ->join('jam_kerja', 'jk_dept_detail.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
                ->join('jk_dept', 'jk_dept_detail.kode_jk_dept', '=', 'jk_dept.kode_jk_dept')
                ->where('kode_dept', $kode_dept)->where('kode_cabang', $kode_cabang)->where('hari', $namahari)->first();
        }

        if ($jamkerja == null) {
            return view('presensi.notifabsen');
        } else {
            return view('presensi.create', compact('cek', 'lokasi_kantor', 'jamkerja'));
        }
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $namahari = $this->gethari();
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $lokasi_kantor = DB::table('tbl_cabang')->where('kode_cabang', $kode_cabang)->first();
        $lok = explode(",", $lokasi_kantor->lokasi_cabang);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasi_user = explode(",", $lokasi);
        $latitudeuser = $lokasi_user[0];
        $longitudeuser = $lokasi_user[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('tbl_presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        $jamkerja = DB::table('set_jamKerja')
            ->join('jam_kerja', 'set_jamKerja.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
            ->where('nik', $nik)->where('hari', $namahari)->first();

        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        if ($radius > $lokasi_kantor->radius_cabang) {
            echo "error|Maaf, Anda diluar jangkauan radius " . $radius . "meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf Anda Belum Bisa Absen, Silahkan Lihat Jam Pulang Absen|in";
                } else {
                    $data_pulang = [
                        'jam_out'       => $jam,
                        'foto_out'      => $fileName,
                        'lokasi_out'    => $lokasi
                    ];
                    $update = DB::table('tbl_presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "success|Terima Kasih, Selamat Beristirahat|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|out";
                    }
                }
            } else {
                if ($jam < $jamkerja->awal_jam_in) {
                    echo "error|Maaf Anda Belum Bisa Absen, Silahkan Lihat Jam Masuk Absen|in";
                } else if ($jam > $jamkerja->akhir_jam_in) {
                    echo "error|Maaf Anda Gagal Absen, Silahkan Lihat Jam Akhir Absen|in";
                } else {
                    $data = [
                        'nik'          => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in'       => $jam,
                        'foto_in'      => $fileName,
                        'lokasi_in'    => $lokasi,
                        'kode_jamKerja' => $jamkerja->kode_jamKerja,
                        'status' => 'h'
                    ];
                    $simpan = DB::table('tbl_presensi')->insert($data);
                    if ($simpan) {
                        echo "success|Terima Kasih, Selamat Gawe, Utamakan Keselamatan Kerja ya|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal Absen, Silahkan Hubungi IT|in";
                    }
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

        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp'        => $no_hp,
                'foto'         => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp'        => $no_hp,
                'password'     => $password,
                'foto'         => $foto
            ];
        }
        $update = DB::table('tbl_karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);;
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('tbl_presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if (!empty($request->tahun) && !empty($request->bulan)) {
            $dataizin = DB::table('tbl_pengajuan')
                ->orderBy('tgl_izin_dari', 'desc')
                ->leftJoin('tbl_cuti', 'tbl_pengajuan.kode_cuti', '=', 'tbl_cuti.kode_cuti')
                ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
                ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
                ->where('nik', $nik)->get();
        } else {
            $dataizin = DB::table('tbl_pengajuan')
                ->orderBy('tgl_izin_dari', 'desc')
                ->leftJoin('tbl_cuti', 'tbl_pengajuan.kode_cuti', '=', 'tbl_cuti.kode_cuti')
                ->where('nik', $nik)->limit(5)->orderBy('tgl_izin_dari', 'desc')
                ->get();
        }
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.izin', compact('dataizin', 'namabulan'));
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

        if ($izin) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Ajukan!!']);
        } else {
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
            ->select('tbl_presensi.*', 'nama_lengkap', 'nama_dept', 'jam_masuk', 'nama_jamKerja', 'jam_pulang')
            ->leftJoin('tbl_karyawan', 'tbl_presensi.nik', '=', 'tbl_karyawan.nik')
            ->leftJoin('tbl_dept', 'tbl_karyawan.kode_dept', '=', 'tbl_dept.kode_dept')
            ->leftJoin('jam_kerja', 'tbl_presensi.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
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
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('tbl_karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporanpresensi', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik   = $request->nik;
        $karyawan = DB::table('tbl_karyawan')->where('nik', $nik)
            ->join('tbl_dept', 'tbl_karyawan.kode_dept', '=', 'tbl_dept.kode_dept')
            ->first();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $presensi = DB::table('tbl_presensi')
            ->leftJoin('jam_kerja', 'tbl_presensi.kode_jamKerja', '=', 'jam_kerja.kode_jamKerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();
        if (isset($_POST['excel'])) {
            $time = date("d-M-Y H:i:s");

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap-Laporan-Presensi-$nik-$time.xls");
            return view('presensi.cetaklaporan1', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekappresensi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.rekappresensi', compact('namabulan',));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari = $tahun . '-' . $bulan . '-01';
        $sampai = date('Y-m-t', strtotime($dari));

        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }
        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];

        if ($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } elseif ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        } elseif ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL, NULL);
        }

        $rekap = DB::table('qv_rekap')->get();

        if (isset($_POST['excel'])) {
            $time = date("d-M-Y H:i:s");

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi $time.xls");
        }

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.rekap', compact('rekap', 'namabulan', 'bulan', 'tahun', 'rangetanggal', 'jmlhari'));
    }

    public function datapengajuan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $nik = $request->nik;
        $nama = $request->nama_lengkap;
        $status = $request->status_approved;


        $query = Pengajuan::query();
        $query->select('id_izin', 'tgl_izin_dari', 'tgl_izin_sampai', 'tbl_pengajuan.nik', 'nama_lengkap', 'jabatan', 'status', 'keterangan', 'status_approved');
        $query->join('tbl_karyawan', 'tbl_pengajuan.nik', '=', 'tbl_karyawan.nik');
        if (!empty($dari) && !empty($sampai)) {
            $query->whereBetween('tgl_izin_dari', [$dari, $sampai]);
        }

        if (!empty($nik)) {
            $query->where('tbl_pengajuan.nik', $nik);
        }
        if (!empty($nama)) {
            $query->where('nama_lengkap', 'like', '%' . $nama . '%');
        }
        if ($status === "0" || $status == '1' || $status == '2') {
            $query->where('status_approved', $status);
        }
        $query->orderBy('tgl_izin_dari', 'desc');
        $pengajuan = $query->paginate(10);
        $pengajuan->appends($request->all());

        $pengajuan_now = DB::table('tbl_pengajuan')
            ->join('tbl_karyawan', 'tbl_pengajuan.nik', '=', 'tbl_karyawan.nik')
            ->where('tgl_izin_dari', date('Y-m-d'))
            ->orderBy('tgl_izin_dari')
            ->get();
        return view('presensi.pengajuan', compact('pengajuan', 'pengajuan_now', 'dari', 'sampai'));
    }

    public function uppengajuan(Request $request, $id_izin)
    {
        $status = $request->status_approved;
        $datapengajuan = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->first();
        $tgl_dari = $datapengajuan->tgl_izin_dari;
        $tgl_sampai = $datapengajuan->tgl_izin_sampai;
        DB::beginTransaction();
        try {
            if ($status == 1) {
                while (strtotime($tgl_dari) <= strtotime($tgl_sampai)) {

                    DB::table('tbl_presensi')->insert([
                        'nik' => $datapengajuan->nik,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $datapengajuan->status,
                        'id_izin' => $datapengajuan->id_izin
                    ]);
                    $tgl_dari = date("Y-m-d", strtotime("+1 days", strtotime($tgl_dari)));
                }
            } else if ($status == 2) {
                DB::table('tbl_presensi')->where('nik', $datapengajuan->nik)->whereBetween('tgl_presensi', [$tgl_dari, $tgl_sampai])->delete();
            }
            DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update([
                'status_approved' => $status
            ]);
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !!']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function batalkan($id_izin)
    {
        $datapengajuan = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->first();
        $tgl_dari = $datapengajuan->tgl_izin_dari;
        $tgl_sampai = $datapengajuan->tgl_izin_sampai;
        $update = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->update([
            'status_approved' => 0
        ]);

        if ($update) {
            DB::table('tbl_presensi')->where('nik', $datapengajuan->nik)->whereBetween('tgl_presensi', [$tgl_dari, $tgl_sampai])->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate !!']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate !!']);
        }
    }

    public function cekpengajuan(Request $request)
    {
        $tgl_izin = $request->tgl_izin_dari;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('tbl_pengajuan')->where('nik', $nik)->where('tgl_izin_dari', $tgl_izin)->count();
        return $cek;
    }

    public function showact($kode_izin)
    {
        $wIzin = DB::table('tbl_pengajuan')->where('id_izin', $kode_izin)->first();
        return view('absen.showact', compact('wIzin'));
    }

    public function deleteizin($id_izin)
    {
        $delete = DB::table('tbl_pengajuan')->where('id_izin', $id_izin)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus !!']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Dihapus !!']);
        }
    }
}
