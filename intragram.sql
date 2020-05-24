-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2020 at 01:58 PM
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
  `BlogId` text NOT NULL,
  `Heading` text NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` text NOT NULL,
  `Image` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `BlogId`, `Heading`, `Created`, `UserId`, `Image`) VALUES
(1, '1_1588424895', 'Nice Post', '2020-05-02 13:08:15', 'deepakgupta191199', NULL),
(2, '1_1588995805', '1st', '2020-05-09 03:43:25', 'deepakgupta191199', NULL),
(3, '1_1588995812', '2nd', '2020-05-09 03:43:32', 'deepakgupta191199', NULL),
(4, '1_1588995820', '3rd', '2020-05-09 03:43:40', '1', NULL),
(5, '1_1588995828', '4th', '2020-05-09 03:43:48', '1', NULL),
(6, '1_1588995842', '5th', '2020-05-09 03:44:02', '1', NULL),
(7, '1_1588996098', '6th', '2020-05-09 03:48:18', '1', NULL),
(8, '1_1588996124', '7th', '2020-05-09 03:48:44', '1', NULL),
(9, '1_1590061533', 'd', '2020-05-21 11:45:33', 'deepakgupta191199', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Username` text NOT NULL,
  `RollNo` text NOT NULL,
  `Email` text NOT NULL,
  `ProfilePic` text NOT NULL,
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

INSERT INTO `users` (`id`, `Name`, `Username`, `RollNo`, `Email`, `ProfilePic`, `Designation`, `Branch`, `Gender`, `Contact`, `Address`, `Password`) VALUES
(1, 'Deepak Gupta', 'deepakgupta191199', '', 'b180081@nitsikkim.ac.in', '', 'STUDENT', 'NuStart', 'MALE', 123, '123', '202cb962ac59075b964b07152d234b70'),
(2, 'Deepak Gupta', '', '', 'b180w081@nitsikkim.ac.in', '', 'STUDENT', 'NuStart', 'MALE', 1234, '123', '202cb962ac59075b964b07152d234b70'),
(3, 'Deepak Gupta', 'deepakgupta789', '123', 'b180079@nitsikkim.ac.in', '', 'STUDENT', 'ECE', 'MALE', 1233, '12312', '202cb962ac59075b964b07152d234b70'),
(4, 'Deepak Guptad', '', '12323', 'd@gmail.xom', '', 'STUDENT', 'ECE', 'MALE', 12312, '123123', '43cca4b3de2097b9558efefd0ecc3588'),
(5, 'Deepak Guptad', '', 'b180021', 'ghost@gmail.com', '', 'STUDENT', 'ECE', 'MALE', 12313, '1231344', 'f7e0ef389ac6133c88aedbd66b44a4e1'),
(6, 'hojjf', '', '123', 'eqweq@gmailc.om', '', 'STUDENT', 'CSE', 'MALE', 12354353, 'fwefw', '1c65cef3dfd1e00c0b03923a1c591db4');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
