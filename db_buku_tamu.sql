-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jan 2025 pada 18.34
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
-- Database: `db_buku_tamu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_tamu`
--

CREATE TABLE `buku_tamu` (
  `id_tamu` int(11) NOT NULL,
  `nama_tamu` varchar(100) NOT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku_tamu`
--

INSERT INTO `buku_tamu` (`id_tamu`, `nama_tamu`, `instansi`, `alamat`, `no_telepon`, `keperluan`, `tanggal_kunjungan`) VALUES
(1, 'delfian', 'pt indofood', 'bekasi', '0853232324', 'Meeting', '2024-09-16'),
(2, 'Susanti', 'PT.KYB Indonesia', 'cikarang', '02189394334', 'Meeting', '2024-11-05'),
(3, 'Ali', 'Pt.Astra', 'cikarang', '0832323743', 'meeting', '2024-11-04'),
(8, 'agus', 'PT.Sufindo', 'Cikarang', '02189238329', 'Meeting', '2024-12-01'),
(9, 'siti', 'Pt.Liong', 'Cikarang', '083263232', 'Meeting', '2024-11-02'),
(29, 'Diska', 'Pt.Yamaha', 'Jl.Irian No.3,Cikarang Barat', '021783278323', 'Meeting', '2024-12-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `role`) VALUES
(1, 'Ariqoh', 'admin', '$2y$10$sqxj9m9D3rs1Hy5gMXRUH.Es4HB5O9ZOKfOoMFIUvcSdXhlwBNof6', 'petugas'),
(2, 'Zhafira', 'pile', '$2y$10$HxwcTsqVcxlTUz2OHOMeWuB3XFwjgeLOwH4ao2TDA8H4s3p0Jw5wC', 'petugas'),
(3, 'Nabila', 'nabila', '$2y$10$SpnK8dL1dGchYO14s12yi.KFBqzDpUif7xYMHIBVvPAUBtQNwMQAi', 'petugas'),
(4, 'Wita', 'wita', '$2y$10$Jy4C6gM/y41kbbV0LWGLd.VFbWZWvYd6dw48DyLzjauR6Z0S5Hlgy', 'petugas'),
(8, 'Basri', 'basri', '$2y$10$m9GqjcrOlgQvZR9ihRZNDufq00kK0lVhaBM2CcVrxBRUSyvOGYHv.', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekapitulasi_buku_tamu`
--

CREATE TABLE `rekapitulasi_buku_tamu` (
  `id_rekap` int(11) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jumlah_tamu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku_tamu`
--
ALTER TABLE `buku_tamu`
  ADD PRIMARY KEY (`id_tamu`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `rekapitulasi_buku_tamu`
--
ALTER TABLE `rekapitulasi_buku_tamu`
  ADD PRIMARY KEY (`id_rekap`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku_tamu`
--
ALTER TABLE `buku_tamu`
  MODIFY `id_tamu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `rekapitulasi_buku_tamu`
--
ALTER TABLE `rekapitulasi_buku_tamu`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
