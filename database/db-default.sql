-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2024 at 09:53 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-default`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_menu`
--

CREATE TABLE `a_menu` (
  `hdrid` varchar(50) NOT NULL,
  `menu_id` varchar(5) DEFAULT NULL,
  `menu_name` varchar(25) DEFAULT NULL,
  `controller` varchar(25) DEFAULT NULL,
  `parent_id` varchar(25) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `a_role`
--

CREATE TABLE `a_role` (
  `role_id` varchar(50) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_role`
--

INSERT INTO `a_role` (`role_id`, `role_name`, `description`, `timestamp`) VALUES
('RL3301001', 'Admin', 'Administrator', '2024-07-16 17:34:47'),
('RL3301002', 'User', 'User', '2024-07-16 17:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `a_role_access`
--

CREATE TABLE `a_role_access` (
  `hdrid` varchar(50) NOT NULL,
  `role_id` varchar(50) DEFAULT NULL,
  `menu_id` varchar(5) DEFAULT NULL,
  `allow_add` varchar(5) DEFAULT NULL,
  `allow_edit` varchar(5) DEFAULT NULL,
  `allow_delete` varchar(5) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `a_user_system`
--

CREATE TABLE `a_user_system` (
  `id_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `role_id` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_user_system`
--

INSERT INTO `a_user_system` (`id_user`, `username`, `password`, `nama`, `foto`, `role_id`, `timestamp`) VALUES
('USR0717001', 'ID0717001', '202cb962ac59075b964b07152d234b70', 'Editor', 'USR0717001_1721202671.jpg', 'RL3301001', '2024-07-17 07:52:20'),
('USR0731001', 'ID0731001', '202cb962ac59075b964b07152d234b70', 'Client', 'USR0731001_1721202697.png', 'RL3301002', '2024-07-17 07:51:37'),
('USR0757001', 'ID0757001', '202cb962ac59075b964b07152d234b70', 'Administrator', 'USR0757001_1721202767.jpg', 'RL3301001', '2024-07-17 07:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `id_agenda` varchar(25) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_berita`
--

CREATE TABLE `tb_berita` (
  `id_berita` varchar(50) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `active` varchar(5) DEFAULT NULL,
  `tgl_upload` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_berita`
--

INSERT INTO `tb_berita` (`id_berita`, `judul`, `foto`, `active`, `tgl_upload`) VALUES
('ID0807001', 'Donald Trump Masuk Daftar Tokoh Dunia yang Pernah Selamat dari Percobaan Pembunuhan', 'ID0807001_foto.jpg', 'Y', '2024-07-17'),
('ID0907001', 'BMKG: Bediding di Yogyakarta Terpengaruh Monsoon Australia dan Akan Berlangsung Hingga Agustus', 'ID0907001_foto.jpg', 'Y', '2024-07-17'),
('ID807002', 'Kylian Mbappe Resmi Jadi Pemain Baru Real Madrid, Ini Pesan-pesan Florentino Perez', 'ID807002_foto.jpg', 'Y', '2024-07-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_menu`
--
ALTER TABLE `a_menu`
  ADD PRIMARY KEY (`hdrid`);

--
-- Indexes for table `a_role`
--
ALTER TABLE `a_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `a_role_access`
--
ALTER TABLE `a_role_access`
  ADD PRIMARY KEY (`hdrid`);

--
-- Indexes for table `a_user_system`
--
ALTER TABLE `a_user_system`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indexes for table `tb_berita`
--
ALTER TABLE `tb_berita`
  ADD PRIMARY KEY (`id_berita`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
