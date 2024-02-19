-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 06:41 AM
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
-- Database: `db_hnd_asignments`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `document_id` varchar(40) NOT NULL,
  `document` varchar(200) NOT NULL,
  `file_size` varchar(15) DEFAULT '0.0 MB',
  `student_name` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'none',
  `submitted_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

-- INSERT INTO `documents` (`id`, `document_id`, `document`, `file_size`, `student_name`, `status`, `submitted_on`) VALUES
-- (1, '176040E6892F7E2BD8', 'DOC-00-INVOICE.pdf', '0.0 MB', 'Ank Lee', 'none', '2023-11-11 16:30:37'),
-- (2, 'C1C095F8E3B9AFE59D', 'DOC-01-INVOICE.pdf', '0.0 MB', 'Ank Lee', 'none', '2023-11-11 16:30:45'),
-- (3, '79A1E1E2FC7BC7F2F8', 'DOC-02-INVOICE.pdf', '0.0 MB', 'Ank Lee', 'none', '2023-11-11 16:30:57'),
-- (4, '813B11388EF282CEA5', 'DOC-03-INVOICE.pdf', '0.0 MB', 'Ank Lee', 'none', '2023-11-11 16:41:59'),
-- (5, '220B9D7EAC4DB0287E', 'DOC-04-INVOICE.pdf', '0.0 MB', 'John Doe', 'none', '2023-11-11 16:56:37'),
-- (6, '917A22FDEE47E80B77', 'DOC-05-INVOICE.pdf', '0.076 MB', 'Ankain Lesly', 'none', '2023-11-11 19:53:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
