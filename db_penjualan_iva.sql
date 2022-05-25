-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2022 pada 14.15
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_penjualan_iva`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) NOT NULL DEFAULT '0',
  `gambar` varchar(500) NOT NULL,
  `deskripsi` text NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `harga`, `stok`, `gambar`, `deskripsi`, `deleted_at`, `created_at`, `updated_at`) VALUES
(5, 'Deskmate Gaming | 300 x 100 cm', 'deskmate-gaming-300-x-100-cm', 450000, 60, 'produk-puAL5Uw4yF-1653473448.jpeg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus laboriosam adipisci natus numquam tempora cum, sit quas exercitationem accusantium explicabo odit quod, deleniti consequatur porro aliquam. Commodi officiis rerum adipisci.', NULL, '2022-05-25 12:10:48', '2022-05-25 12:10:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_nm` varchar(100) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `role_nm`, `is_admin`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 1, NULL, '2022-05-19 00:00:00', '2022-05-19 00:00:00'),
(2, 'marketing', 1, NULL, '2022-05-19 00:00:00', '2022-05-19 00:00:00'),
(3, 'customer', 0, NULL, '2022-05-19 00:00:00', '2022-05-19 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `password`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'superuser', 1, 'superuser@iva.com', '$2y$10$jTTPiJDgIs1vZ2.vxMYT8.8QqNxpe/yRdAX70vtiw82ySZrhwqUAO', 1, '2022-05-19 16:10:44', '2022-05-19 16:10:44', NULL),
(5, 'dummycustomer2', 3, 'dummycustomer2@iva.com', '$2y$10$tAamrtznyxoXjYLkP0SPO.t1kp7pi9cJsOI6xfqpACd0vMTEWq7Ui', 1, '2022-05-22 12:10:54', '2022-05-22 12:10:54', NULL),
(6, 'Aji Pujo Hardiyanto', 3, 'ajipujo@iva.com', '$2y$10$WV7rbNCSlFZn.VF22KVjpOqLbdWsGhgrNpO.g0cd4azhclv3bktva', 1, '2022-05-23 18:01:57', '2022-05-23 18:01:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
