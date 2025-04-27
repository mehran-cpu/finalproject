-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2025 at 08:16 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gymhubdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `register_login`
--

DROP TABLE IF EXISTS `register_login`;
CREATE TABLE IF NOT EXISTS `register_login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `register_login`
--

INSERT INTO `register_login` (`id`, `username`, `email`, `password`, `role`) VALUES
(6, 'abol', 'kdbjhadhj@gmail.com', '22', 'user'),
(5, 'ali', 'mhranaryamhr23@gmail.com', '1234', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sports_supplements`
--

DROP TABLE IF EXISTS `sports_supplements`;
CREATE TABLE IF NOT EXISTS `sports_supplements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `price` int NOT NULL,
  `image` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports_supplements`
--

INSERT INTO `sports_supplements` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'پودر گینر گلد دکتر سان - 3 کیلوگرم', 'کمک به تامین کربوهیدرات و پروتئین مورد نیاز ورزشکار', 1997690, 'uploads/mahsol1.webp');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
