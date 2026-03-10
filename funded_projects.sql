-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2026 at 06:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `funded_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `year_approved` int(11) NOT NULL,
  `beneficiary` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `fund_amount` decimal(15,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_details` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `city_municipality` varchar(255) NOT NULL,
  `district` varchar(50) NOT NULL,
  `priority_sector` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `year_approved`, `beneficiary`, `contact_person`, `fund_amount`, `email`, `contact_details`, `address`, `city_municipality`, `district`, `priority_sector`, `created_at`) VALUES
(1, 2025, 'ADEA GOLD REFINERY', 'ERLAND F. BARRUN', 2221029.00, 'erlandbarrun528@gmail.com', '9555832615', 'Purok Chavez, Brgy. Edward', 'T\'BOLI', '3rd', 'MEALS AND MINING', '2026-03-10 03:43:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
