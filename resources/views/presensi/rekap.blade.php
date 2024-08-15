<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Rekap Laporan</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: Letter
        }

        #h3 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tblkaryawan {
            margin-top: 40px;
        }

        .tblkaryawan td {
            padding: 5px;
        }

        .presensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .presensi tr th {
            border: 1px solid #000;
            padding: 8px;
            background: #dbdbdb;
            font-size: 10px;
        }

        .presensi tr td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="Letter landscape">
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%;">
            <tr>
                <td style="width: 30px;"><img src="{{ asset('assets/img/icon/i.png') }}" width="100px" height="100px"
                        alt=""></td>
                <td><span id="h3">
                        REKAP LAPORAN PRESENSI KARYAWAN <br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        CV. DADE STORE<br>
                    </span>
                    <span><i>Jln. Kapten Jamhur No.365, Dsn. Cimenyan II RT 03/08 Desa Mekarsari Kec. Banjar,
                            Banjar</i></span>
                </td>
            </tr>
        </table>

        <table class="presensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th rowspan="2">Jabatan</th>
                <th colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                <th rowspan="2">H</th>
                <th rowspan="2">I</th>
                <th rowspan="2">S</th>
                <th rowspan="2">C</th>
                <th rowspan="2">A</th>
            </tr>
            <tr>
                @foreach ($rangetanggal as $d)
                    @if ($d != null)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endif
                @endforeach
            </tr>
            @foreach ($rekap as $r)
                <tr>
                    <td>{{ $r->nik }}</td>
                    <td>{{ $r->nama_lengkap }}</td>
                    <td>{{ $r->jabatan }}</td>
                    <?php
                    $jml_hadir = 0;
                    $jml_sakit = 0;
                    $jml_ijin = 0;
                    $jml_cuti = 0;
                    $jml_tanpa_keterangann = 0;
                    ?>
                    @for ($i = 1; $i <= $jmlhari; $i++)
                        <?php
                        $tgl = 'tgl_' . $i;
                        $datapresensi = explode('|', $r->$tgl);
                        if ($r->$tgl != null) {
                            $status = $datapresensi[2];
                        } else {
                            $status = '';
                        }
                        
                        if ($status == 'h') {
                            $jml_hadir += 1;
                        } elseif ($status == 'c') {
                            $jml_cuti += 1;
                        } elseif ($status == 'i') {
                            $jml_ijin += 1;
                        } elseif ($status == '') {
                            $jml_tanpa_keterangann += 1;
                        } elseif ($status == 's') {
                            $jml_sakit += 1;
                        }
                        ?>
                        <td style="text-align: center; {{ $status != null ? '' : 'background-color: #FF0000' }}">
                            @if ($r->$tgl != null)
                                {{ $status }}
                            @endif
                        </td>
                    @endfor
                    <td style="text-align: center">
                        {{ $jml_hadir }}
                    </td>
                    <td style="text-align: center">
                        {{ $jml_ijin }}
                    </td>
                    <td style="text-align: center">
                        {{ $jml_sakit }}
                    </td>
                    <td style="text-align: center">
                        {{ $jml_cuti }}
                    </td>
                    <td style="text-align: center">
                        {{ $jml_tanpa_keterangann }}
                    </td>
                </tr>
            @endforeach

        </table>


        <table width="100%" style="margin-top: 100px;">
            <tr>
                <td></td>
                <td style="text-align: center;">Banjar, {{ date('d-m-Y') }} </td>
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
