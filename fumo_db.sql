-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2022 at 01:36 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fumo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_devices`
--

CREATE TABLE `available_devices` (
  `device_id` varchar(30) NOT NULL,
  `owner_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `available_devices`
--

INSERT INTO `available_devices` (`device_id`, `owner_email`) VALUES
('1234', NULL),
('3244', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `User_email` varchar(255) NOT NULL,
  `User_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_devices`
--
ALTER TABLE `available_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `owner_email` (`owner_email`),
  ADD KEY `owner_email_2` (`owner_email`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`User_email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `available_devices`
--
ALTER TABLE `available_devices`
  ADD CONSTRAINT `available_devices_ibfk_1` FOREIGN KEY (`owner_email`) REFERENCES `user_info` (`User_email`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
