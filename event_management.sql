-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 02:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `department`) VALUES
(1, 'Sumon', 'sumon295@gmail.com', '$2y$10$Si.EjRdnQlXY9/ZZVQgMNOhXlVy3hWG9lQKY7X5U9Qd0MofTn1Ke.', 'cse'),
(2, 'sumon', 'sumon1@gmail.com', '$2y$10$pLBo2PO8VPUkR5loP4xGuO6kIOLYx4iZbFVANnU/Z..CoCEhAtOOS', 'cse');

-- --------------------------------------------------------

--
-- Table structure for table `advisors`
--

CREATE TABLE `advisors` (
  `advisor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `segment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisors`
--

INSERT INTO `advisors` (`advisor_id`, `name`, `email`, `department`, `segment_id`) VALUES
(1, 'Sumon', 'cseku220212@gmail.com', 'CSE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `annouse_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `club_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_member` decimal(10,2) DEFAULT NULL,
  `club_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`club_id`, `name`, `total_member`, `club_type`) VALUES
(1, 'Cluster', 200.00, 'Cultural'),
(2, 'Cluster', 200.00, 'Cultural');

-- --------------------------------------------------------

--
-- Table structure for table `committees`
--

CREATE TABLE `committees` (
  `committee_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `advisor_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `segment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committees`
--

INSERT INTO `committees` (`committee_id`, `name`, `event_id`, `advisor_id`, `email`, `department`, `segment_id`) VALUES
(1, 'any', 3, NULL, 'cseku@gmail.com', 'CSE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_student` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `name`, `total_student`) VALUES
(2, 'cse', 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `club_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `club_id`, `dept_id`, `description`, `start_date`, `end_date`, `admin_id`, `image_path`) VALUES
(3, 'Dance fest', 1, NULL, 'fdfs', '2024-11-26', '2024-11-08', 2, NULL),
(5, 'SynergyX', 1, NULL, 'Event organized by CSE discipline.', '2024-11-27', '2024-11-30', 2, NULL),
(7, 'SynergyX24', NULL, 2, 'sfsf', '2024-12-01', '2024-12-05', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `segment_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `regi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `segment_id`, `amount`, `description`, `sponsor_id`, `event_id`, `regi_id`) VALUES
(3, NULL, 300000.00, 'BdREN is a software company ltd.\r\nthey sponsored for our event .\r\ntotal amount : 3,00,000 BDT', 8, 3, NULL),
(4, 4, 500.00, 'Registration Fee', NULL, 3, 3),
(5, 3, 0.00, 'Registration Fee', NULL, 5, 4),
(6, 4, 500.00, 'Registration Fee', NULL, 3, 5),
(7, 4, 500.00, 'Registration Fee', NULL, 3, 6),
(8, 5, 500.00, 'Registration Fee', NULL, 5, 8),
(9, 1, 300.00, 'Registration Fee', NULL, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `regi_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `segment_id` int(11) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `regi_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`regi_id`, `user_id`, `segment_id`, `registration_date`, `regi_fee`) VALUES
(1, 5, 4, '2024-11-27 11:33:45', NULL),
(2, 5, 3, '2024-11-27 11:43:56', NULL),
(3, 5, 4, '2024-11-26 18:00:00', 500),
(4, 5, 3, '2024-11-26 18:00:00', 0),
(5, 5, 4, '2024-11-26 18:00:00', 500),
(6, 5, 4, '2024-11-27 18:00:00', 500),
(7, 5, 2, '2024-11-29 13:19:41', NULL),
(8, 5, 5, '2024-11-28 18:00:00', 500),
(9, 5, 1, '2024-11-28 18:00:00', 300);

-- --------------------------------------------------------

--
-- Table structure for table `segments`
--

CREATE TABLE `segments` (
  `segment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `segment_type` varchar(255) DEFAULT NULL,
  `segment_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `segments`
--

INSERT INTO `segments` (`segment_id`, `name`, `event_id`, `description`, `segment_type`, `segment_fee`) VALUES
(1, 'Dance', 3, 'make sure dance for entertaining.', 'Competition', 300),
(2, 'CP', 5, 'Participate more than 45 teams', 'Competition', 450),
(3, 'Hackathon', 5, 'Open for all', 'Workshop', 10000),
(4, 'Local', 3, 'Local Uradhura.', 'Competition', 500),
(5, 'Game', 5, 'gamw', 'Competition', 500);

-- --------------------------------------------------------

--
-- Table structure for table `sponsorships`
--

CREATE TABLE `sponsorships` (
  `sponsor_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `sponsor_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsorships`
--

INSERT INTO `sponsorships` (`sponsor_id`, `event_id`, `sponsor_name`, `amount`) VALUES
(1, 3, 'Spread love', 300000.00),
(8, 3, 'BdREN', 300000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `department`, `password`) VALUES
(2, 'Sumon', 'sumon12@gmail.com', 'cse', '$2y$10$AUBrQxbbYxdhS7/bv6KN0.HS4BjhmVfcv1Y0GqW5UV/BzsbJQAKmm'),
(3, 'saad', 'saad@gmail.com', 'cse', '$2y$10$s2dy9oQ2HGIN1JjAuSqLmOnl3Dpx779.RD8qYcDDxSHpaAhrmsR1y'),
(4, 'sohag', 'sohag@gmail.com', 'cse', '$2y$10$3SqDxCWayBMrv4UnEQT75.zf/winzzjWlpvaEtDp.rH5H/RZdaSzi'),
(5, 'Sumon', 'ssumon@gmail.com', 'CSE', '$2y$10$E70miUsg.g86./dCnQXfrOqXebiLBca9lwF6RmjSQhJ1B7F601B7u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`advisor_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_segment` (`segment_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`annouse_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `committees`
--
ALTER TABLE `committees`
  ADD PRIMARY KEY (`committee_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `advisor_id` (`advisor_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `club_id` (`club_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `segment_id` (`segment_id`),
  ADD KEY `fk_sponsor` (`sponsor_id`),
  ADD KEY `fk_event` (`event_id`),
  ADD KEY `fk_regi` (`regi_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`regi_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `segment_id` (`segment_id`);

--
-- Indexes for table `segments`
--
ALTER TABLE `segments`
  ADD PRIMARY KEY (`segment_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD PRIMARY KEY (`sponsor_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `advisors`
--
ALTER TABLE `advisors`
  MODIFY `advisor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `annouse_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `committees`
--
ALTER TABLE `committees`
  MODIFY `committee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `regi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `segments`
--
ALTER TABLE `segments`
  MODIFY `segment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `sponsor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisors`
--
ALTER TABLE `advisors`
  ADD CONSTRAINT `fk_segment` FOREIGN KEY (`segment_id`) REFERENCES `segments` (`segment_id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `committees`
--
ALTER TABLE `committees`
  ADD CONSTRAINT `committees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `committees_ibfk_2` FOREIGN KEY (`advisor_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`club_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `departments` (`dept_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `fk_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `fk_regi` FOREIGN KEY (`regi_id`) REFERENCES `registrations` (`regi_id`),
  ADD CONSTRAINT `fk_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `sponsorships` (`sponsor_id`),
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`segment_id`) REFERENCES `segments` (`segment_id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`segment_id`) REFERENCES `segments` (`segment_id`) ON DELETE CASCADE;

--
-- Constraints for table `segments`
--
ALTER TABLE `segments`
  ADD CONSTRAINT `segments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `sponsorships`
--
ALTER TABLE `sponsorships`
  ADD CONSTRAINT `sponsorships_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
