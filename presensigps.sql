-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 25 Apr 2024 pada 19.40
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensigps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `config_lokasi`
--

CREATE TABLE `config_lokasi` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `radius` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `config_lokasi`
--

INSERT INTO `config_lokasi` (`id`, `lokasi`, `radius`) VALUES
(1, '-6.37690894343114, 106.81946562337876', '70');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `kode_jamKerja` varchar(20) NOT NULL,
  `nama_jamKerja` varchar(50) NOT NULL,
  `awal_jam_in` varchar(20) NOT NULL,
  `jam_masuk` varchar(20) NOT NULL,
  `akhir_jam_in` varchar(20) NOT NULL,
  `jam_pulang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jam_kerja`
--

INSERT INTO `jam_kerja` (`kode_jamKerja`, `nama_jamKerja`, `awal_jam_in`, `jam_masuk`, `akhir_jam_in`, `jam_pulang`) VALUES
('RP', 'Reg Pagi', '06:00:00', '06:30:00', '07:00:00', '16:00:00'),
('RS', 'Reg Sore', '16:00:00', '16:30:00', '17:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jk_dept`
--

CREATE TABLE `jk_dept` (
  `kode_jk_dept` varchar(11) NOT NULL,
  `kode_cabang` varchar(11) NOT NULL,
  `kode_dept` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jk_dept`
--

INSERT INTO `jk_dept` (`kode_jk_dept`, `kode_cabang`, `kode_dept`) VALUES
('JDPKIT', 'DPK', 'IT'),
('JTSMIT', 'TSM', 'IT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jk_dept_detail`
--

CREATE TABLE `jk_dept_detail` (
  `kode_jk_dept` varchar(11) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `kode_jamKerja` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jk_dept_detail`
--

INSERT INTO `jk_dept_detail` (`kode_jk_dept`, `hari`, `kode_jamKerja`) VALUES
('JDPKIT', 'Senin', 'RP'),
('JDPKIT', 'Selasa', 'RP'),
('JDPKIT', 'Rabu', 'RP'),
('JDPKIT', 'Kamis', NULL),
('JDPKIT', 'Jumat', NULL),
('JDPKIT', 'Sabtu', NULL),
('JDPKIT', 'Minggu', NULL),
('JTSMIT', 'Senin', 'RP'),
('JTSMIT', 'Selasa', 'RP'),
('JTSMIT', 'Rabu', 'RP'),
('JTSMIT', 'Kamis', 'RP'),
('JTSMIT', 'Jumat', 'RS'),
('JTSMIT', 'Sabtu', 'RS'),
('JTSMIT', 'Minggu', 'RP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `set_jamKerja`
--

CREATE TABLE `set_jamKerja` (
  `nik` int(11) NOT NULL,
  `hari` varchar(15) NOT NULL,
  `kode_jamKerja` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `set_jamKerja`
--

INSERT INTO `set_jamKerja` (`nik`, `hari`, `kode_jamKerja`) VALUES
(12345, 'Senin', 'RP'),
(12345, 'Selasa', 'RP'),
(12345, 'Rabu', 'RP'),
(12345, 'Kamis', 'RS'),
(12345, 'Jumat', 'RP'),
(12345, 'Sabtu', 'RP'),
(12345, 'Minggu', 'RP'),
(12346, 'Senin', 'RP'),
(12346, 'Selasa', 'RP'),
(12346, 'Rabu', 'RP'),
(12346, 'Kamis', 'RP'),
(12346, 'Jumat', 'RS'),
(12346, 'Sabtu', 'RP'),
(12346, 'Minggu', 'RS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_cabang`
--

CREATE TABLE `tbl_cabang` (
  `kode_cabang` varchar(11) NOT NULL,
  `nama_cabang` varchar(50) NOT NULL,
  `alamat_cabang` varchar(100) NOT NULL,
  `lokasi_cabang` varchar(50) NOT NULL,
  `radius_cabang` varchar(10) NOT NULL,
  `kontak` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_cabang`
--

INSERT INTO `tbl_cabang` (`kode_cabang`, `nama_cabang`, `alamat_cabang`, `lokasi_cabang`, `radius_cabang`, `kontak`) VALUES
('DPK', 'YPLB Nusantara', 'Depok', '-6.373015752586626, 106.82945349052247', '100', '089663366710'),
('TSM', 'Cabang Tasikmalaya', 'Tasikmalaya', '-6.412579579436457, 106.83027958155552', '100', '089663366710');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_cuti`
--

CREATE TABLE `tbl_cuti` (
  `kode_cuti` varchar(11) NOT NULL,
  `nama_cuti` varchar(20) NOT NULL,
  `jml_hari` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_cuti`
--

INSERT INTO `tbl_cuti` (`kode_cuti`, `nama_cuti`, `jml_hari`) VALUES
('C01', 'Tahunan', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dept`
--

CREATE TABLE `tbl_dept` (
  `kode_dept` varchar(20) NOT NULL,
  `nama_dept` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dept`
--

INSERT INTO `tbl_dept` (`kode_dept`, `nama_dept`) VALUES
('IT', 'Teknologi Informasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_karyawan`
--

CREATE TABLE `tbl_karyawan` (
  `nik` int(17) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kode_dept` varchar(20) NOT NULL,
  `kode_cabang` varchar(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_karyawan`
--

INSERT INTO `tbl_karyawan` (`nik`, `nama_lengkap`, `jabatan`, `no_hp`, `password`, `foto`, `kode_dept`, `kode_cabang`, `remember_token`) VALUES
(12345, 'Hermin, S.Pd', 'Master of IT', '082118471055', '$2y$10$ATp6y8cPGEd6IUuDZ2HwxekJfUkJc/rW2rQJfASU8dzEOlQdl8YEy', '12345.png', 'IT', 'DPK', NULL),
(12346, 'Indra', 'Master of IT', '082118471055', '$2y$10$78lw/bflKljAF.Edi1yyB.3FDXVcGL.bIqZxLqEQxstH6dbOtkUMW', '12346.jpg', 'IT', 'TSM', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id_izin` varchar(11) NOT NULL,
  `nik` int(17) NOT NULL,
  `tgl_izin_dari` varchar(30) NOT NULL,
  `tgl_izin_sampai` varchar(30) NOT NULL,
  `status` varchar(1) NOT NULL,
  `sid` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) NOT NULL,
  `kode_cuti` varchar(11) DEFAULT NULL,
  `status_approved` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pengajuan`
--

INSERT INTO `tbl_pengajuan` (`id_izin`, `nik`, `tgl_izin_dari`, `tgl_izin_sampai`, `status`, `sid`, `keterangan`, `kode_cuti`, `status_approved`) VALUES
('IC112023002', 12345, '2023-11-16', '2023-11-20', 'c', NULL, 'Izin Pulang Kampung', 'C01', 0),
('IS112023002', 12345, '2023-11-27', '2023-11-28', 's', 'sid-12345.png', 'Sakit Pusing', NULL, 0),
('IZ112023001', 12345, '2023-11-16', '2023-11-20', 'i', NULL, 'Izin Pulang Kampung', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_presensi`
--

CREATE TABLE `tbl_presensi` (
  `id_presensi` int(11) NOT NULL,
  `nik` int(17) NOT NULL,
  `tgl_presensi` varchar(50) NOT NULL,
  `jam_in` varchar(50) DEFAULT NULL,
  `jam_out` varchar(50) DEFAULT NULL,
  `foto_in` varchar(50) NOT NULL,
  `foto_out` varchar(50) DEFAULT NULL,
  `lokasi_in` varchar(50) NOT NULL,
  `lokasi_out` varchar(50) DEFAULT NULL,
  `kode_jamKerja` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_presensi`
--

INSERT INTO `tbl_presensi` (`id_presensi`, `nik`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `kode_jamKerja`) VALUES
(6, 12345, '2023-10-19', '16:47:45', NULL, '12345-2023-10-19-in.png', NULL, '-6.3764714,106.8199032', '-6.3764714,106.8199032', 'RS'),
(7, 12346, '2023-11-03', '16:41:05', NULL, '12346-2023-11-03-in.png', NULL, '-6.4126976,106.8302336', NULL, 'RS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`) VALUES
(1, 'Indra Maulana', 'inmaulana09@gmail.com', '$2y$10$tYDNKxvfRj9UbyZv1MNf2e5lKJXU51Dc8z8hqPJGTxUduIciP1T06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `config_lokasi`
--
ALTER TABLE `config_lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD UNIQUE KEY `kode_jamKerja` (`kode_jamKerja`);

--
-- Indeks untuk tabel `jk_dept`
--
ALTER TABLE `jk_dept`
  ADD PRIMARY KEY (`kode_jk_dept`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cabang`
--
ALTER TABLE `tbl_cabang`
  ADD UNIQUE KEY `kode_cabang` (`kode_cabang`);

--
-- Indeks untuk tabel `tbl_dept`
--
ALTER TABLE `tbl_dept`
  ADD UNIQUE KEY `kode_dept` (`kode_dept`);

--
-- Indeks untuk tabel `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD PRIMARY KEY (`id_izin`);

--
-- Indeks untuk tabel `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD PRIMARY KEY (`id_presensi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `config_lokasi`
--
ALTER TABLE `config_lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  MODIFY `nik` int(17) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12349;

--
-- AUTO_INCREMENT untuk tabel `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
