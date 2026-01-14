-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 03:50 AM
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
-- Database: `ci4trainingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `tracking_number` varchar(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `origin_office_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `current_office_id` int(11) DEFAULT NULL,
  `current_status` enum('Pending','Received','Forwarded','Completed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `tracking_number`, `title`, `description`, `origin_office_id`, `date_created`, `created_by`, `current_office_id`, `current_status`) VALUES
(1, 'TRK-001', 'Purchase Request', 'Request for office supplies', 1, '2025-11-13 21:13:51', 1, 3, 'Pending'),
(2, 'TRK-002', 'Leave Application', 'Leave request from staff', 3, '2025-11-13 21:13:51', 3, 3, 'Pending'),
(3, 'TRK-1763449150-404', 'testing', 'test', 1, '2025-11-18 14:59:10', 7, 3, 'Pending'),
(4, 'TRK-1763450306-837', 'testing', 'test', 1, '2025-11-18 15:18:26', 7, 3, 'Pending'),
(5, 'TRK-1763450560-601', 'testing testing', 'testing testing', 1, '2025-11-18 15:22:40', 7, 3, 'Completed'),
(6, 'TRK-1763512765-724', 'Testing 123', 'meow', 1, '2025-11-19 08:39:25', 7, 2, 'Forwarded'),
(7, 'TRK-1763514766-506', 'testttt', 'Testinggg', 1, '2025-11-19 09:12:46', 7, 3, 'Completed'),
(8, 'TRK-1763517786-703', 'testing', 'test', 1, '2025-11-19 10:03:06', 9, 2, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `document_logs`
--

CREATE TABLE `document_logs` (
  `log_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `sender_office_id` int(11) NOT NULL,
  `receiver_office_id` int(11) DEFAULT NULL,
  `action` enum('Received','Forwarded','Released') NOT NULL,
  `remarks` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `handled_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_logs`
--

INSERT INTO `document_logs` (`log_id`, `document_id`, `sender_office_id`, `receiver_office_id`, `action`, `remarks`, `timestamp`, `handled_by`) VALUES
(1, 1, 1, 2, 'Forwarded', 'Sent to Finance for approval', '2025-11-13 21:13:51', 1),
(2, 2, 3, 1, 'Forwarded', 'Sent to Admin for review', '2025-11-13 21:13:51', 3),
(3, 3, 3, 1, 'Forwarded', 'asdassa', '2025-11-18 15:40:37', 8),
(4, 4, 3, NULL, '', 'Document marked as complete.', '2025-11-18 15:42:38', 8),
(5, 4, 3, NULL, '', 'Document marked as complete.', '2025-11-18 15:42:41', 8),
(6, 4, 3, NULL, '', 'Document marked as complete.', '2025-11-18 15:45:27', 8),
(7, 6, 1, NULL, '', 'Document has been registered in the system.', '2025-11-19 08:39:25', 7),
(8, 1, 3, NULL, 'Released', 'Document marked as complete.', '2025-11-19 08:41:06', 8),
(9, 2, 3, NULL, 'Released', 'Document marked as complete.', '2025-11-19 08:41:08', 8),
(10, 7, 1, NULL, '', 'Document has been registered in the system.', '2025-11-19 09:12:46', 7),
(11, 7, 1, 3, 'Forwarded', 'Budget Approved', '2025-11-19 09:13:24', 1),
(12, 7, 3, NULL, 'Released', 'Document marked as complete.', '2025-11-19 09:14:12', 8),
(13, 8, 2, NULL, '', 'Document has been registered in the system.', '2025-11-19 10:03:06', 9),
(14, 6, 3, 2, 'Forwarded', 'ok', '2025-11-19 10:04:02', 8),
(15, 5, 3, NULL, 'Released', 'Document marked as complete.', '2025-11-19 10:04:05', 8);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_name` varchar(100) NOT NULL,
  `office_code` varchar(10) NOT NULL,
  `office_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office_name`, `office_code`, `office_description`) VALUES
(1, 'General Administrations', 'GAs', 'Handles general administrative functions'),
(2, 'Finance Department', 'FIN', 'Responsible for budgeting and finances'),
(3, 'Human Resources', 'HR', 'Manages employee records and HR policies');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','encoder') NOT NULL DEFAULT 'staff',
  `office_id` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `password`, `role`, `office_id`, `status`) VALUES
(1, 'Admin User', 'admin@admin.com', '$2y$10$0uJrdvlFufjNzszsSqmX2upYHcfnFKP/UCDOjHVNXUs5xN17oKI.W', 'admin', 1, 'active'),
(2, 'Finance Staff', 'staff@staff.com', '$2y$10$jZ8Yprc1cFRtxrN29PbvKOpjn9fExycEcJBj6z2vE2PCSsTeWTxW2', 'staff', 2, 'active'),
(7, 'Mr. Encoder', 'Encoder', '$2y$10$d88eFsKxDKrRMHuW01mHau8cg/hLpJOeQ3iFxZkOcLp7827pbE4dq', 'encoder', 1, 'active'),
(8, 'Staff Number 1', 'Staff', '$2y$10$VDT1lcIH1pWjsfMgsV5uV.tkaUTgagEk6xp43rRPtrrn3WHiU50Kq', 'staff', 3, 'active'),
(9, 'Mohammad Zailon', 'zailon1234', '$2y$10$X5Psq79PUTD180pTgp7wIuUhHRjkAnagBsb6JYIegCIm/V1Z6vbCS', 'encoder', 2, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`);

--
-- Indexes for table `document_logs`
--
ALTER TABLE `document_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `document_logs`
--
ALTER TABLE `document_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
