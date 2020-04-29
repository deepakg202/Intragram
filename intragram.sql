-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2020 at 07:09 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intragram`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `BlogID` text NOT NULL,
  `Caption` text NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Image` text NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `RollNo` text NOT NULL,
  `Email` text NOT NULL,
  `Designation` enum('STUDENT','FACULTY') NOT NULL,
  `Branch` text NOT NULL,
  `Gender` enum('MALE','FEMALE') NOT NULL,
  `Contact` int(11) NOT NULL,
  `Address` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Name`, `RollNo`, `Email`, `Designation`, `Branch`, `Gender`, `Contact`, `Address`, `Password`) VALUES
(1, 'Deepak Gupta', '', 'b180081@nitsikkim.ac.in', 'STUDENT', 'NuStart', 'MALE', 123, '123', '202cb962ac59075b964b07152d234b70'),
(2, 'Deepak Gupta', '', 'b180w081@nitsikkim.ac.in', 'STUDENT', 'NuStart', 'MALE', 1234, '123', '202cb962ac59075b964b07152d234b70'),
(3, 'Deepak Gupta', '123', 'b180079@nitsikkim.ac.in', 'STUDENT', 'ECE', 'MALE', 1233, '12312', '202cb962ac59075b964b07152d234b70'),
(4, 'Deepak Guptad', '12323', 'd@gmail.xom', 'STUDENT', 'ECE', 'MALE', 12312, '123123', '43cca4b3de2097b9558efefd0ecc3588');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
