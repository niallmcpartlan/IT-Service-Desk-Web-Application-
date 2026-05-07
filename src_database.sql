-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 11:55 PM
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
-- Database: `src_database`
--
CREATE DATABASE IF NOT EXISTS `src_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `src_database`;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT DELAYED IGNORE INTO `comments` (`id`, `ticket_id`, `user_id`, `comment_text`, `created_at`) VALUES
(3, 1, 8, 'gdfh', '2026-01-15 16:12:55'),
(4, 1, 8, 'xds', '2026-01-15 16:13:20'),
(5, 1, 8, 'wrsg', '2026-01-15 16:14:05'),
(6, 4, 9, 'dsaa', '2026-01-15 18:56:18'),
(7, 1, 9, 'hello niall', '2026-01-15 19:11:37'),
(8, 11, 8, 'demo comment', '2026-01-22 12:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `help_guides`
--

DROP TABLE IF EXISTS `help_guides`;
CREATE TABLE `help_guides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `uploaded_by` varchar(100) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `help_guides`
--

INSERT DELAYED IGNORE INTO `help_guides` (`id`, `title`, `description`, `filename`, `uploaded_by`, `uploaded_at`) VALUES
(1, 'Test Screenshot', 'test', 'guide_696c226500fe90.53842146.png', 's_jcunningham', '2026-01-17 23:59:33'),
(3, 'tester', 'tetsljuis', 'guide_696c2a3a5c6a28.82059933.png', 's_jcunningham', '2026-01-18 00:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT DELAYED IGNORE INTO `roles` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) DEFAULT 'open',
  `priority` varchar(50) DEFAULT 'medium',
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT DELAYED IGNORE INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `priority`, `category`, `created_at`, `updated_at`) VALUES
(1, 8, 'xxx12', 'xxxxxxx1112', 'Closed', 'Low', 'Other', '2026-01-15 01:00:33', '2026-01-17 21:23:17'),
(3, 9, 'dbfd', 'db', 'Open', 'Medium', 'Software', '2026-01-15 18:01:27', '2026-01-17 20:05:15'),
(4, 9, 'f', 'f', 'Closed', 'Low', 'Hardware', '2026-01-15 18:02:06', '2026-01-17 21:23:16'),
(5, 8, '12346', '78909', 'Open', 'Medium', 'Software', '2026-01-17 19:57:43', '2026-01-18 01:05:40'),
(6, 8, 'vfdsvgds', 'vasdvgfs', 'Closed', 'Low', 'Hardware', '2026-01-17 19:59:56', '2026-01-18 00:44:10'),
(7, 9, 'ff', 'ff', 'Closed', 'Low', 'Hardware', '2026-01-17 21:52:21', '2026-01-18 01:05:33'),
(10, 8, 'testtest', 'testtest', 'Open', 'Low', 'Hardware', '2026-01-19 17:06:37', '2026-01-19 17:06:37'),
(11, 8, 'demo', 'demo', 'Open', 'Low', 'Hardware', '2026-01-22 12:02:49', '2026-01-22 12:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT DELAYED IGNORE INTO `users` (`id`, `username`, `password`, `email`, `role_id`, `created_at`, `is_admin`) VALUES
(8, 'nmcpartlan', '$2y$10$WUqSrL7yYS9qSpFru3hHz.SyfLZRF/QG1gb1UP2oqLMt2oDq.ZvS.', 'nmcpartlan@srcsolutions.com', 2, '2026-01-14 22:02:13', 0),
(9, 's_jcunningham', '$2y$10$L.2JLFrI7/OJ0k61JbF89uM2rY3PHhW.Rk94jSEGSZ5pgKYJ9DBIa', 's_jcunningham@srcsolutions.com', 1, '2026-01-14 22:49:30', 0),
(10, 'jbloggs', '$2y$10$aHUBL93drFEptTh0cF/HXOmWdD2h1.Kde3jmYGtwH5/TMp7rFuz5y', 'jbloggs@srcsolutions.com', 2, '2026-01-21 20:12:54', 0),
(13, 'admin', '$2y$10$RAgDufWFvMTcI6tvNRBd6eX.l7mlmHW/7gOuoZoogJQSYE7Z/lVxO', 'admin@srcsolutions.com', 1, '2026-01-21 20:18:36', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `help_guides`
--
ALTER TABLE `help_guides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `help_guides`
--
ALTER TABLE `help_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
