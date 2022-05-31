-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2022 at 11:05 AM
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
-- Table structure for table `device_data`
--

CREATE TABLE `device_data` (
  `device_id` varchar(30) DEFAULT NULL,
  `Temperature` varchar(50) DEFAULT NULL,
  `Humidity` varchar(50) DEFAULT NULL,
  `reading_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `User_email` varchar(255) NOT NULL,
  `User_password` varchar(100) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Birth_date` date DEFAULT NULL,
  `User_type` varchar(30) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`User_email`, `User_password`, `First_Name`, `Last_Name`, `Birth_date`, `User_type`) VALUES
('123124', 'saddaw', '', '', NULL, 'User'),
('12weqwe', 'qweqe213', '', '', NULL, 'User'),
('2311ads', 'sdadad', '', '', NULL, 'User'),
('adawd', 'dawdawddad', '', '', NULL, 'User'),
('dasdasda', '1321313', '', '', NULL, 'User'),
('putainga 12312', 'weqweq', '', '', NULL, 'User'),
('qweqwe', 'qweqwe', '', '', NULL, 'User'),
('sdszgzersga', 'rwzdcvbzd', '', '', NULL, 'User'),
('svxcvxbxcbv', 'bzxvzxcvzb', '', '', NULL, 'User'),
('test', 'zxczxcvzv', '', '', NULL, 'User');

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
