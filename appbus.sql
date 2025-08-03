-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Agu 2025 pada 15.43
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appbus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bus`
--

CREATE TABLE `bus` (
  `id` int NOT NULL,
  `kode_bus` varchar(10) DEFAULT NULL,
  `asal` varchar(100) DEFAULT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `jumlah_kursi` int DEFAULT '43',
  `gambar` varchar(255) DEFAULT NULL,
  `harga_per_kursi` int DEFAULT '50000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bus`
--

INSERT INTO `bus` (`id`, `kode_bus`, `asal`, `tujuan`, `tanggal`, `jam`, `jumlah_kursi`, `gambar`, `harga_per_kursi`) VALUES
(11, '0001', 'Terminal Purabaya', 'Terminal Wates', '2026-08-12', '12:00:00', 42, NULL, 150000),
(12, '0002', 'Terminal Tugu', 'Terminal Kediri', '2026-07-27', '11:24:00', 43, NULL, 60000),
(13, '0005', 'Terminal Yogyakarta', 'Terminal Madura', '2025-08-31', '23:30:00', 43, NULL, 150000),
(14, '0003', 'Terminal Purabaya', 'Terminal Wates', '2027-07-30', '10:30:00', 43, NULL, 70000),
(15, '0010', 'Terminal Giwangan', 'Terminal Arjosari', '2027-02-26', '12:00:00', 43, NULL, 100000),
(16, '0123', 'Terminal Purabaya', 'Terminal Wates', '3025-02-23', '10:20:00', 43, NULL, 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi_tiket`
--

CREATE TABLE `kursi_tiket` (
  `id` int NOT NULL,
  `tiket_id` int DEFAULT NULL,
  `nomor_kursi` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kursi_tiket`
--

INSERT INTO `kursi_tiket` (`id`, `tiket_id`, `nomor_kursi`) VALUES
(48, 52, 1),
(49, 53, 9),
(50, 54, 10),
(51, 55, 1),
(53, 57, 18),
(54, 58, 15),
(55, 59, 14),
(56, 60, 14),
(58, 62, 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `scan_log`
--

CREATE TABLE `scan_log` (
  `id` int NOT NULL,
  `tiket_id` int DEFAULT NULL,
  `waktu_scan` datetime DEFAULT NULL,
  `kernet_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `scan_log`
--

INSERT INTO `scan_log` (`id`, `tiket_id`, `waktu_scan`, `kernet_id`) VALUES
(42, 53, '2025-08-01 09:43:58', 2),
(43, 55, '2025-08-01 09:53:52', 2),
(44, 52, '2025-08-01 09:54:19', 2),
(45, 57, '2025-08-02 15:20:50', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `bus_id` int DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `status` enum('belum_bayar','sudah_bayar','digunakan','kadaluarsa') DEFAULT 'belum_bayar',
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id`, `user_id`, `bus_id`, `tanggal_pesan`, `status`, `metode_pembayaran`, `total_harga`, `barcode`) VALUES
(52, 3, 11, '2025-08-03', 'sudah_bayar', 'QRIS', 25000, 'TIKET68865f6ed4038'),
(53, 3, 11, '2025-08-03', 'digunakan', 'Transfer', 150000, 'TIKET6886fa83f113b'),
(54, 3, 11, '2025-08-03', 'belum_bayar', '', 150000, 'TIKET6886fa90a2223'),
(55, 3, 13, '2025-08-31', 'digunakan', 'qris', 150000, 'TIKET688c8e7fde010'),
(57, 3, 13, '2025-08-31', 'digunakan', 'qris', 150000, 'TIKET688e2ca75acbc'),
(58, 3, 11, '2025-08-03', 'sudah_bayar', 'qris', 150000, 'TIKET688e30745510b'),
(59, 3, 11, '2025-08-03', 'sudah_bayar', 'qris', 150000, 'TIKET688e530fb88a6'),
(60, 3, 13, '2025-08-31', 'belum_bayar', NULL, 150000, 'TIKET688e5df5c20d2'),
(62, 3, 11, '2025-08-03', 'belum_bayar', NULL, 150000, 'TIKET688f4ff57565a');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `role` enum('admin','pembeli','kernet') DEFAULT 'pembeli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `no_hp`, `role`) VALUES
(1, 'Admin Utama', 'admin@example.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567890', 'admin'),
(2, 'Cak Adam', 'adm@kernet.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567891', 'kernet'),
(3, 'muhsin', 'muhsin@gmail.com', '$2y$10$Yqagzw0EAzaxMJtJq5vEY.McIS85vvyMEbDjjdFOfLQhIAB/FVNBS', '081234567834', 'pembeli'),
(5, 'Ihsan Baihaqi', 'ihsan@gmail.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567893', 'pembeli'),
(6, 'Nur Hidayat', 'hidayat@gmail.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567894', 'pembeli'),
(7, 'Bintang Bayu', 'bay@gmail.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567895', 'pembeli'),
(8, 'Nihayati', 'nii@gmail.com', '$2y$10$H0AtRaF.C5Ey9nVWlYxZEOAmjM9ukMr3KHKj9gfx9EL59FDgK85qu', '081234567896', 'pembeli'),
(9, 'Oktafiana', 'okta@gmail.com', '$2y$10$unqqPPp0/lAq8Ka6RxeWD.I.K/X6OAYV6UhmwzEEMPc4wDBVC.Zr6', '08123451234', 'pembeli'),
(10, 'Faturrohman', 'fatur@gmail.com', '$2y$10$EIuPpEqv.cJVeaibVoKY..bf6ILcpl4fn26cqSdXublvJaJOw5gGa', '12345678912', 'pembeli'),
(11, 'Lutfika Ardani', 'lutfika@gmail.com', '$2y$10$Voi4YCQOsKkeqDFu3vP8/ubxhkTZVIGS/QPaLnHsoNg7fP550hIkK', '12345678900', 'pembeli'),
(12, 'Rizky Wahyu', 'rizky@gmail.com', '$2y$10$i/XqVTVCNIqGAomifdz00.VMyUBESc6n3mZZc/KdDck9GECKAHxUW', '122222222222', 'pembeli'),
(13, 'Bambang', 'bambang@kernet.com', '$2y$10$F0v7oOTebRH6lL.iCuMTvurOXBMN60/6s9kH.8oWO5o4fpO/4WgDi', '085173235050', 'kernet');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_bus` (`kode_bus`);

--
-- Indeks untuk tabel `kursi_tiket`
--
ALTER TABLE `kursi_tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tiket` (`tiket_id`);

--
-- Indeks untuk tabel `scan_log`
--
ALTER TABLE `scan_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kernet_id` (`kernet_id`),
  ADD KEY `fk_tiket_scan_log` (`tiket_id`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kursi_tiket`
--
ALTER TABLE `kursi_tiket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `scan_log`
--
ALTER TABLE `scan_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kursi_tiket`
--
ALTER TABLE `kursi_tiket`
  ADD CONSTRAINT `fk_tiket` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kursi_tiket_ibfk_1` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`);

--
-- Ketidakleluasaan untuk tabel `scan_log`
--
ALTER TABLE `scan_log`
  ADD CONSTRAINT `fk_tiket_scan_log` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scan_log_ibfk_1` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`id`),
  ADD CONSTRAINT `scan_log_ibfk_2` FOREIGN KEY (`kernet_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
