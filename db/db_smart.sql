-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2022 pada 12.33
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_smart`
--
CREATE DATABASE IF NOT EXISTS `db_smart` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_smart`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tab_alternatif`
--

CREATE TABLE `tab_alternatif` (
  `id_alternatif` varchar(10) NOT NULL,
  `nama_alternatif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tab_alternatif`
--

INSERT INTO `tab_alternatif` (`id_alternatif`, `nama_alternatif`) VALUES
('A01', 'Scania 32'),
('A02', 'Mercedes 52'),
('A03', 'Big Bus SHD'),
('A04', 'Medium Bus 30'),
('A05', 'Hi Ace 30'),
('A06', 'Jetbus 65'),
('A07', 'Legacy SR2'),
('A08', 'Skylander 14'),
('A09', 'Jetliner 14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tab_evaluation`
--

CREATE TABLE `tab_evaluation` (
  `id_alternatif` varchar(10) NOT NULL,
  `id_kriteria` varchar(10) NOT NULL,
  `nilai` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tab_evaluation`
--

INSERT INTO `tab_evaluation` (`id_alternatif`, `id_kriteria`, `nilai`) VALUES
('A01', 'C1', 2),
('A01', 'C2', 2),
('A01', 'C3', 1),
('A01', 'C4', 2),
('A01', 'C5', 1),
('A01', 'C6', 2),
('A02', 'C1', 2),
('A02', 'C2', 1),
('A02', 'C3', 2),
('A02', 'C4', 1),
('A02', 'C5', 3),
('A02', 'C6', 2),
('A03', 'C1', 4),
('A03', 'C2', 5),
('A03', 'C3', 2),
('A03', 'C4', 1),
('A03', 'C5', 3),
('A03', 'C6', 5),
('A04', 'C1', 3),
('A04', 'C2', 3),
('A04', 'C3', 2),
('A04', 'C4', 3),
('A04', 'C5', 3),
('A04', 'C6', 3),
('A05', 'C1', 2),
('A05', 'C2', 2),
('A05', 'C3', 2),
('A05', 'C4', 2),
('A05', 'C5', 1),
('A05', 'C6', 2),
('A06', 'C1', 1),
('A06', 'C2', 1),
('A06', 'C3', 3),
('A06', 'C4', 2),
('A06', 'C5', 3),
('A06', 'C6', 2),
('A07', 'C1', 2),
('A07', 'C2', 2),
('A07', 'C3', 2),
('A07', 'C4', 4),
('A07', 'C5', 3),
('A07', 'C6', 2),
('A08', 'C1', 2),
('A08', 'C2', 3),
('A08', 'C3', 4),
('A08', 'C4', 4),
('A08', 'C5', 2),
('A08', 'C6', 1),
('A09', 'C1', 1),
('A09', 'C2', 3),
('A09', 'C3', 4),
('A09', 'C4', 5),
('A09', 'C5', 3),
('A09', 'C6', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tab_kriteria`
--

CREATE TABLE `tab_kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tab_kriteria`
--

INSERT INTO `tab_kriteria` (`id_kriteria`, `nama_kriteria`, `attribute`, `bobot`) VALUES
('C1', 'Mesin dan Transmisi', 'benefit', 3),
('C2', 'Sistem Kemudi', 'benefit', 1),
('C3', 'Rangka dan Body Bus', 'benefit', 4),
('C4', 'Pengereman dan Penerangan', 'benefit', 2),
('C5', 'Ban dan Velg Bus', 'cost', 3),
('C6', 'Usia Armada', 'cost', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `status` enum('Y','N') NOT NULL,
  `id_session` char(5) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`, `level`, `status`, `id_session`, `date`) VALUES
(3, 'admin', 'admin', 'admin', 'admin', 'admin', 'Y', 'v4f2a', '2020-11-03'),
(5, 'pengunjung', 'pengunjung', 'pengunjung', 'pengunjung@gmail.com', 'user', 'Y', 'mkj34', '2021-04-13'),
(9, 'user', 'user', 'user', '', 'user', 'Y', '9mebn', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tab_alternatif`
--
ALTER TABLE `tab_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `tab_evaluation`
--
ALTER TABLE `tab_evaluation`
  ADD KEY `FK_tab_evaluation_tab_alternatif` (`id_alternatif`) USING BTREE,
  ADD KEY `FK_tab_evaluation_tab_kriteria` (`id_kriteria`) USING BTREE;

--
-- Indeks untuk tabel `tab_kriteria`
--
ALTER TABLE `tab_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tab_evaluation`
--
ALTER TABLE `tab_evaluation`
  ADD CONSTRAINT `FK_tab_evaluasi_tab_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `tab_alternatif` (`id_alternatif`),
  ADD CONSTRAINT `FK_tab_evaluasi_tab_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `tab_kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
