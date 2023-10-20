-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2023 at 06:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medical_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `channeling_date_tbl`
--

CREATE TABLE `channeling_date_tbl` (
  `id` int(10) NOT NULL,
  `nic` varchar(15) NOT NULL,
  `ch_date` date NOT NULL,
  `booked_date` datetime NOT NULL,
  `channel_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `channeling_date_tbl`
--

INSERT INTO `channeling_date_tbl` (`id`, `nic`, `ch_date`, `booked_date`, `channel_status`) VALUES
(1, '200105101033', '2023-10-21', '2023-10-18 14:26:00', 0),
(2, '200105101034', '2023-10-20', '2023-10-18 14:29:19', 0),
(3, '200105101035', '2023-10-20', '2023-10-18 14:31:52', 0),
(4, '200105101036', '2023-10-19', '2023-10-19 05:17:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_tbl`
--

CREATE TABLE `medicine_tbl` (
  `id` int(10) NOT NULL,
  `nic` varchar(15) NOT NULL,
  `medicine` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_tbl`
--

INSERT INTO `medicine_tbl` (`id`, `nic`, `medicine`, `add_date`) VALUES
(1, '200105101033', 'abc 3', '2023-10-18 14:26:00'),
(2, '200105101034', 'cbd 3', '2023-10-18 14:29:19'),
(3, '200105101035', 'mnx 3', '2023-10-18 14:31:52'),
(4, '200105101036', 'mnk 3', '2023-10-19 05:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `patients_tbl`
--

CREATE TABLE `patients_tbl` (
  `id` int(10) NOT NULL,
  `nic` varchar(15) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `join_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_tbl`
--

INSERT INTO `patients_tbl` (`id`, `nic`, `fname`, `lname`, `gender`, `mobile_no`, `address`, `join_at`, `update_at`) VALUES
(1, '200105101033', 'kamal', 'Perera', 'male', '0711758851', 'Knady', '2023-10-18 14:26:00', '2023-10-18 14:26:00'),
(2, '200105101034', 'Nimali', 'Somaraththne', 'female', '0711758854', 'Walala', '2023-10-18 14:29:19', '2023-10-18 14:29:19'),
(3, '200105101035', 'Nimal', 'Perera', 'male', '0711758852', 'Menihkinna', '2023-10-18 14:31:52', '2023-10-18 14:31:52'),
(4, '200105101036', 'Kumari', 'Somaraththne', 'female', '0711758555', 'Kandy', '2023-10-19 05:17:59', '2023-10-19 05:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `is_active` int(1) NOT NULL,
  `u_access` int(1) NOT NULL,
  `join_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `username`, `email`, `user_pass`, `user_type`, `is_active`, `u_access`, `join_at`, `update_at`) VALUES
(1, 'jehan', 'jehan@123.com', '0192023a7bbd73250516f069df18b500', 'admin', 1, 0, '2023-10-11 15:39:58', '2023-10-11 15:39:58'),
(2, 'nimal', 'jehan@qwe.com', '202cb962ac59075b964b07152d234b70', 'user', 0, 0, '2023-10-11 18:19:05', '2023-10-11 18:19:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `channeling_date_tbl`
--
ALTER TABLE `channeling_date_tbl`
  ADD PRIMARY KEY (`id`,`nic`);

--
-- Indexes for table `medicine_tbl`
--
ALTER TABLE `medicine_tbl`
  ADD PRIMARY KEY (`id`,`nic`);

--
-- Indexes for table `patients_tbl`
--
ALTER TABLE `patients_tbl`
  ADD PRIMARY KEY (`id`,`nic`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channeling_date_tbl`
--
ALTER TABLE `channeling_date_tbl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medicine_tbl`
--
ALTER TABLE `medicine_tbl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients_tbl`
--
ALTER TABLE `patients_tbl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
