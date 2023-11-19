<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Cetak Laporan</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page { size: A4 }
  #h3{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
  }
  .tblkaryawan{
    margin-top: 40px;
  }

  .tblkaryawan td {
    padding: 5px;
  }

  .presensi{
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
  }

  .presensi tr th{
    border: 1px solid #000;
    padding: 8px;
    background: #dbdbdb;
  }

  .presensi tr td{
    border: 1px solid #000;
    padding: 5px;
    font-size: 12px;
  }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
@php
function selisih($jam_masuk, $jam_keluar)
{
    list($h, $m, $s) = explode(":", $jam_masuk);
    $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    list($h, $m, $s) = explode(":", $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];
    return $jml_jam . ":" . round($sisamenit2);
}
@endphp
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%;">
        <tr>
            <td style="width: 30px;"><img src="{{ asset('assets/img/icon/i.png') }}" width="100px" height="100px" alt=""></td>
            <td><span id="h3">
                LAPORAN PRESENSI KARYAWAN <br>
                PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                CV. DADE STORE<br>
                </span>
                <span><i>Jln. Kapten Jamhur No.365, Dsn. Cimenyan II RT 03/08 Desa Mekarsari Kec. Banjar, Banjar</i></span>
            </td>
        </tr>
    </table>

    <table class="tblkaryawan">
        <tr>
            <td rowspan="6">
                @php
                    $path = Storage::url('uploads/karyawan/'.$karyawan->foto);
                @endphp
                <img src="{{ url($path) }}" alt="" width="100px" height="150px">
            </td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $karyawan->nama_dept }}</td>
        </tr>
        <tr>
            <td>No Hp</td>
            <td>:</td>
            <td>{{ $karyawan->no_hp }}</td>
        </tr>
    </table>

    <table class="presensi">
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>NIK</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Keterangan</th>
        <th>Jam Kerja</th>
      </tr>
      @foreach ($presensi as $p)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ date("d-m-Y", strtotime($p->tgl_presensi)) }}</td>
          <td>{{ $p->nik }}</td>
          <td>{{ $p->jam_in }}</td>
          <td>{{ $p->jam_out != null ? $p->jam_out : 'Belum Absen' }}</td>
          <td>
          <td>
            @if ($p->jam_in > $p->jam_masuk)
            @php
               $jam_telat = selisih($p->jam_masuk, $p->jam_in);
            @endphp
                Terlambat {{ $jam_telat }}
            @else
               Tepat Waktu
            @endif
          </td>
          <td>
            @if ($p->jam_out != null)
              @php
              $jmlkerja = selisih($p->jam_in, $p->jam_out);
              @endphp 
            @else
              @php
              $jmlkerja = 0;
              @endphp
            @endif
            {{ $jmlkerja }}
          </td>
        </tr>
      @endforeach
    </table>

    <table width="100%" style="margin-top: 100px;">
      <tr>
        <td></td>
        <td  style="text-align: center;">Banjar, {{ date("d-m-Y") }} </td>
      </tr>
      <tr>
        <td style="text-align: center; vertical-align: bottom" height="100px">
          <u>Indra Maulana</u> <br>
          <i><b>HRD Manager</b></i>
        </td>
        <td style="text-align: center; vertical-align: bottom">
          <u>Hermin, S.Pd</u> <br>
          <i><b>Direktur</b></i>
        </td>
      </tr>
    </table>
  </section>

</body>

</html>