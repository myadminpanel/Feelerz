-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2019 at 07:18 AM
-- Server version: 5.6.41-84.1-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digimonk_ios_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `user_id`, `gig_id`) VALUES
(1, 2, 2),
(2, 2, 1),
(3, 1, 5),
(4, 2, 8),
(5, 2, 16),
(6, 2, 15),
(7, 2, 10),
(8, 39, 25),
(9, 57, 29),
(10, 57, 33),
(11, 129, 25),
(12, 135, 62),
(13, 135, 64),
(14, 141, 68),
(15, 141, 70),
(16, 141, 69),
(17, 143, 72),
(18, 137, 71),
(19, 135, 73),
(20, 1, 72),
(21, 1, 73),
(22, 1, 64),
(23, 144, 72),
(24, 134, 71),
(25, 138, 74),
(26, 146, 71),
(27, 146, 70),
(28, 144, 71),
(29, 142, 74),
(30, 135, 74),
(31, 149, 80),
(32, 160, 81),
(33, 165, 84),
(34, 167, 71),
(35, 142, 84),
(36, 165, 71);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
