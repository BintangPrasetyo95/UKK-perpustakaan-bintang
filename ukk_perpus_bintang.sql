-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Apr 2024 pada 10.36
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
-- Database: `ukk_perpus_bintang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `disable`) VALUES
(1, 'judul1', 'penulis1', 'penerbit1', 2024, 0, 0),
(2, 'judul3', 'penulis2', 'penerbit2', 2025, NULL, 1),
(3, 'judul2', 'penulis2', 'penerbit2', 2024, 11, 0),
(4, 'judul3', '1', '1', 1, NULL, 1),
(5, '123123', '12312', '12', 12, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `disable`) VALUES
(1, '0', 1),
(2, '4', 1),
(3, 'Horror', 0),
(4, 'kategori2', 1),
(5, 'Action', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_relasi`
--

CREATE TABLE `kategori_relasi` (
  `id_kategori_relasi` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_relasi`
--

INSERT INTO `kategori_relasi` (`id_kategori_relasi`, `id_buku`, `id_kategori`, `disable`) VALUES
(2, 1, 3, 1),
(9, 4, 3, 0),
(10, 4, 5, 0),
(11, 3, 5, 1),
(12, 5, 3, 0),
(13, 5, 5, 0),
(14, 1, 3, 1),
(15, 3, 3, 1),
(16, 3, 5, 1),
(17, 3, 5, 1),
(18, 1, 3, 1),
(19, 1, 5, 1),
(20, 1, 5, 1),
(21, 1, 3, 1),
(22, 3, 5, 0),
(23, 1, 5, 0),
(24, 1, 3, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksi`
--

CREATE TABLE `koleksi` (
  `id_koleksi` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `koleksi`
--

INSERT INTO `koleksi` (`id_koleksi`, `id_buku`, `id_user`, `disable`) VALUES
(1, 3, 4, 1),
(2, 3, 4, 1),
(3, 1, 4, 1),
(4, 3, 4, 1),
(5, 3, 4, 1),
(6, 3, 4, 1),
(7, 3, 4, 1),
(8, 3, 4, 1),
(9, 3, 4, 0),
(10, 1, 3, 0),
(11, 1, 1, 0),
(12, 3, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('terpinjam','terkembalikan') NOT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_buku`, `id_user`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `disable`) VALUES
(1, 3, 1, NULL, NULL, 'terpinjam', 1),
(2, 3, 2, NULL, NULL, 'terpinjam', 1),
(3, 1, 2, '2024-04-22', NULL, 'terpinjam', 0),
(4, 1, 1, '2024-04-22', '2024-04-22', 'terkembalikan', 0),
(5, 3, 1, '2024-04-23', NULL, 'terpinjam', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `ulasan` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_user`, `id_buku`, `ulasan`, `rating`, `disable`) VALUES
(1, 4, 1, 'saya suka buku ini', 10, 0),
(2, 2, 1, 'saya TIDAK SUKA buku ini', 3, 0),
(3, 4, 1, 'test123334343', 8, 1),
(4, 1, 1, 'saya peminjam dan saya suka buku ini', 6, 0),
(5, 3, 3, 'kok gini sih bukunya?', 2, 0),
(6, 1, 3, 'mid', 5, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('peminjam','petugas','admin') NOT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `nama_lengkap`, `alamat`, `role`, `disable`) VALUES
(1, 'peminjam', '$2y$10$jfotiw859F0WVBEkQsfZvunbwA.hb1ooK9Cz1sxtF.ZyoL.fL3t1m', 'peminjam_satu@gmail.com', 'Peminjam', 'METRO', 'peminjam', 0),
(2, 'peminjam2', '$2y$10$WCIzAgTOAz9nSsIn7baoAuV1YP/8M2Cx8XN2hjLxNjruB.97eX/6e', 'peminjam_dua@gmail.com', 'Peminjam Dua', 'metro barat', 'peminjam', 0),
(3, 'petugas', '$2y$10$xrPfy.7DdX5PJR9FX7yyFuEz5pw5HruV0u3TnmVfeG4MOCGEWRd6u', 'petugas_satu@gmail.com', 'Petugas', 'jakarta', 'petugas', 0),
(4, 'admin', '$2y$10$h.5AC23hTsEkveh1v0xsAeRhQktkhLv4jtibfcfg3uUtst5dsguyy', 'admin@gmail.com', 'Admin', 'ganjar agung', 'admin', 0),
(5, 'bintang_prasetyo', '$2y$10$8yFSCKZ6KkeiCwfm8ZuYkezAonIVP0/pmEFU4fTN1unf6v.Ywn7T.', 'sutpidotdash@gmail.com', 'Bintang Prasetyo Kusumo Wicaksono', 'Dusun V, RT.014/RW.005, Purwodadi, Trimurjo, Lampung Tengah', 'peminjam', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `kategori_relasi`
--
ALTER TABLE `kategori_relasi`
  ADD PRIMARY KEY (`id_kategori_relasi`),
  ADD KEY `id_buku` (`id_buku`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  ADD PRIMARY KEY (`id_koleksi`),
  ADD KEY `id_buku` (`id_buku`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_buku` (`id_buku`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `id_user` (`id_user`,`id_buku`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_relasi`
--
ALTER TABLE `kategori_relasi`
  MODIFY `id_kategori_relasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  MODIFY `id_koleksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategori_relasi`
--
ALTER TABLE `kategori_relasi`
  ADD CONSTRAINT `kategori_relasi_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `kategori_relasi_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  ADD CONSTRAINT `koleksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `koleksi_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
