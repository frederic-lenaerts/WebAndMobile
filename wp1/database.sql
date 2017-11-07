-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2017 at 03:06 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rolesString` varchar(255) NOT NULL,
  `technician_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `rolesString`, `technician_id`) VALUES
(3, 'Admin', '$2y$13$u6QsaAMb9wFkRS0IkBDUnu9MC3R7gzY53n1KJR7oVc2aKv7NVOvXi', 'ROLE_ADMIN', NULL),
(4, 'Sam', '$2y$13$p4y/jA5uUDknWuYGDnpPTeBqAgawTg8/LsrqoBHqpwMJKLV2NH0Mi', 'ROLE_TECHNICIAN', 0),
(5, 'Yannick', '$2y$13$3LL5fffIUXvawcP9TJ/UUuFHqAVUarcKub4o7NU8tmTefXyA0wSRW', 'ROLE_TECHNICIAN', 1),
(6, 'Frederic', '$2y$13$hkmuCI.tp00W1yrS6gc/4uwz0/6cXeOuXExeKfT3sXL.s4MCrwcOq', 'ROLE_TECHNICIAN', 2),
(7, 'Bert', '$2y$13$XEXezwCsCWyl6bp7SHZyX.aR.KdY/XjqzcPjHMxr0E5fU4ION.Qfa', 'ROLE_TECHNICIAN', 3),
(8, 'Piet', '$2y$13$q3ma5on1QV3hu/qCmNVX8Ok.SWKdUHKkIMz0b2NKKUPmi7JShNwQm', 'ROLE_TECHNICIAN', 4),
(9, 'Manager', '$2y$13$7a/vutBeSrJGcv0VI0HdpO3o1RO5BEY.6XqFkiw2V0kTu9S8s6z/m', 'ROLE_MANAGER', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
