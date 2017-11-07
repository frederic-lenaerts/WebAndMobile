-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2017 at 02:50 PM
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
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `date` date NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `action`, `date`, `location_id`) VALUES
(7, 'Lamp vervangen', '2017-09-29', 2),
(8, 'Lamp vervangen', '2017-09-29', 2),
(9, 'Test', '2017-11-05', 4),
(10, 'Test2', '2017-11-24', 3),
(11, 'tsstr', '2017-11-18', 2);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'London'),
(2, 'New York City'),
(3, 'Tokyo'),
(4, 'Bree');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `handled` tinyint(4) NOT NULL DEFAULT '0',
  `text` text,
  `technician_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `location_id`, `date`, `handled`, `text`, `technician_id`, `action_id`) VALUES
(1, 2, '2017-09-28', 1, NULL, 3, 1),
(4, 3, '2017-08-13', 0, NULL, 4, NULL),
(5, 1, '2016-02-23', 1, NULL, NULL, NULL),
(6, 2, '2017-02-23', 0, NULL, NULL, NULL),
(7, 2, '2017-02-23', 0, NULL, NULL, NULL),
(8, 2, '2017-02-23', 0, NULL, NULL, NULL),
(9, 2, '2017-09-29', 1, NULL, 3, NULL),
(10, 2, '2017-09-29', 1, NULL, NULL, NULL),
(11, 2, '2017-09-15', 1, NULL, NULL, NULL),
(12, 2, '2017-09-15', 1, NULL, 0, NULL),
(13, 2, '2017-09-15', 1, NULL, NULL, NULL),
(14, 2, '2017-09-15', 1, NULL, 0, NULL),
(15, 2, '2017-09-15', 1, NULL, 0, NULL),
(16, 2, '2017-09-15', 1, NULL, NULL, NULL),
(17, 2, '2017-09-15', 1, NULL, 0, NULL),
(18, 2, '2017-09-15', 1, NULL, 0, NULL),
(19, 2, '2017-09-15', 1, NULL, 0, NULL),
(20, 2, '2017-09-28', 1, NULL, 3, NULL),
(21, 2, '2017-09-28', 1, NULL, 0, NULL),
(22, 2, '2017-11-03', 0, NULL, 0, NULL),
(23, 3, '2017-11-25', 1, NULL, 0, NULL),
(24, 4, '2017-11-05', 1, NULL, 0, NULL),
(25, 1, '2017-11-05', 1, NULL, 0, NULL),
(26, 4, '2017-11-05', 0, 'Test', 0, NULL),
(27, 3, '2017-11-10', 0, 'stinky', 0, NULL),
(28, 2, '2017-11-05', 1, 'blabla', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `location_id`, `status`, `date`) VALUES
(1, 2, 2, '2017-09-28'),
(2, 3, 1, '2017-08-13'),
(3, 1, 0, '2016-02-23'),
(4, 2, 1, '2017-12-06'),
(5, 2, 2, '2017-11-01'),
(6, 2, 2, '2017-11-01'),
(7, 4, 2, '2017-11-28'),
(8, 4, 2, '2017-11-28'),
(9, 3, 2, '2017-11-22'),
(10, 3, 2, '2017-11-22'),
(11, 1, 2, '2017-11-06'),
(12, 1, 2, '2017-11-06'),
(13, 2, 2, '2017-11-01'),
(14, 2, 2, '2017-11-01'),
(15, 2, 2, '2017-11-01'),
(16, 2, 2, '2017-11-01'),
(17, 3, 2, '2017-11-09'),
(18, 3, 2, '2017-11-09'),
(19, 4, 0, '2017-11-15'),
(20, 4, 0, '2017-11-15'),
(21, 4, 2, '2017-12-25'),
(22, 4, 2, '2017-12-25'),
(23, 3, 0, '2017-11-17'),
(24, 3, 0, '2017-11-17'),
(25, 1, 0, '2017-10-04'),
(26, 1, 0, '2017-10-04'),
(27, 2, 1, '2018-04-06'),
(28, 2, 1, '2018-04-06'),
(29, 4, 1, '2018-01-19'),
(30, 4, 1, '2018-01-19'),
(31, 2, 0, '2018-02-15'),
(32, 2, 0, '2018-02-15'),
(33, 2, 1, '2017-11-23'),
(34, 2, 1, '2017-11-23'),
(35, 2, 0, '2017-11-01'),
(36, 2, 0, '2017-11-01'),
(37, 2, 1, '2017-11-02'),
(38, 2, 1, '2017-11-02'),
(39, 4, 0, '2017-11-15'),
(40, 4, 0, '2017-11-15'),
(41, 1, 2, '2017-11-14'),
(42, 1, 2, '2017-11-14'),
(43, 3, 2, '2017-11-19'),
(44, 3, 2, '2017-11-19'),
(45, 4, 1, '2017-11-15'),
(46, 4, 1, '2017-11-15'),
(47, 3, 1, '2017-11-01'),
(48, 3, 1, '2017-11-01'),
(49, 2, 0, '2017-11-01'),
(50, 2, 0, '2017-11-01'),
(51, 2, 0, '2017-11-08'),
(52, 2, 0, '2017-11-08'),
(53, 4, 1, '2017-11-25'),
(54, 4, 1, '2017-11-25'),
(55, 3, 0, '2017-11-15'),
(56, 3, 0, '2017-11-15');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `name`, `location_id`) VALUES
(0, 'Sam', 3),
(1, 'Yannick', 4),
(2, 'Frederic', 1),
(3, 'Bert', 2),
(4, 'Piet', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rolesString` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `rolesString`) VALUES
(1, 'Admin', '$2y$13$1sHWVm7cYq7T0s/gpTFgB.DCxxXzbHTPZGDsqWhqI8rRTZLfpg9Eu', 'ROLE_ADMIN'),
(2, 'Technician', '$2y$13$s6Jh3f9U7A5jOgAyp/SgJuS0Fhp4B0kyBFEni2us8fRUSu1jQkw8G', 'ROLE_TECHNICIAN'),
(3, 'Manager', '$2y$13$71TFTigf8dtMRBR7cpb5JenEr3u7zul/UAUs/y8fVVdInKd/40M42', 'ROLE_MANAGER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

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
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
