-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2020 at 03:33 PM
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
  `blog_id` text NOT NULL,
  `heading` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` text NOT NULL,
  `image_link` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `blog_id`, `heading`, `created`, `user_id`, `image_link`) VALUES
(1, '1_1590989412', 'THE FIRST POST', '2020-06-01 05:30:12', '1', NULL),
(2, '13_1591019432', 'Superman', '2020-06-01 13:50:32', '13', NULL),
(3, '1_1591287433', 'Post With Image', '2020-06-04 16:17:13', '1', NULL),
(4, '1_1591287449', 'Post With Image', '2020-06-04 16:17:29', '1', NULL),
(5, '1_1591287556', 'POST IMAGE', '2020-06-04 16:19:16', '1', NULL),
(6, '1_1591287641', 'POSF IMGE', '2020-06-04 16:20:41', '1', 'https://i.imgur.com/7XrZ5uf.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `profile_pic` text NOT NULL,
  `contact` text NOT NULL,
  `about` text,
  `password` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `profile_pic`, `contact`, `about`, `password`, `created`) VALUES
(1, 'Deepak Gupta', 'deepakgupta191199', 'b180081@nitsikkim.ac.in', '', '123', '', '202cb962ac59075b964b07152d234b70', '2020-05-27 13:23:27'),
(3, 'Deepak Gupta', 'deepakgupta789', 'b180079@nitsikkim.ac.in', '', '1233', '', '202cb962ac59075b964b07152d234b70', '2020-05-27 13:23:27'),
(13, 'SuperMan', 'superman123', 'superman@gmail.com', 'https://api.adorable.io/avatars/512/superman123', '9900', 'SuperHero', '202cb962ac59075b964b07152d234b70', '2020-06-01 13:50:11'),
(12, 'Ghost', 'deepakfgup', 'df@gmail.com', 'https://api.adorable.io/avatars/512/deepakfgup', '2424', 'Godds', 'c20ad4d76fe97759aa27a0c99bff6710', '2020-05-30 16:15:14');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
