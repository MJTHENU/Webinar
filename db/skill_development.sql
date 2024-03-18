-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2024 at 05:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skill_development`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `gender` enum('male','female','others','') NOT NULL,
  `college` varchar(250) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `mobile_no`, `gender`, `college`, `degree`, `department`, `city`) VALUES
(1, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(2, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(3, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(4, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(5, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(6, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai'),
(7, 'sathish', 's', 'sathish123@gmail.com', '9363160663', 'male', 'VHNSNC ', 'BA', 'English', 'Surandai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
