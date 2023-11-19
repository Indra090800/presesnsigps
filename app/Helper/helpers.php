<?php

function hitungjamterlambar($jam_masuk, $jam_presensi){
    $j1 = strtotime($jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat/(60*60));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60*60)))/60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $terlambat = $jterlambat . ":" . $mterlambat;
    return $terlambat;
}

function hitunghari($tgl_mulai, $tgl_akhir){
    $tgl_1 = date_create($tgl_mulai);
    $tgl_2 = date_create($tgl_akhir);
    $jmlHari = date_diff($tgl_1,$tgl_2);

    return $jmlHari->days + 1;
}

function buatkode($nomor_terakhir, $kunci, $jml_karakter = 0){
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jml_karakter,"0", STR_PAD_LEFT);
    $kode = $kunci. $nomor_baru_plus_nol;
    return $kode;
}
