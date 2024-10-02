-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-rudra-maityrudra228-93ec.a.aivencloud.com:16999
-- Generation Time: Oct 02, 2024 at 03:39 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `tags`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'The CPUdf fdsdf', '<h3>sdsadsaddfdsdf</h3>', '', 'draft', '2024-10-01 14:23:40', '2024-10-02 12:04:11'),
(6, 1, 'dsfsa', '<pre>dsadsad</pre>', 'dddsad', 'published', '2024-10-01 17:41:46', '2024-10-02 12:05:14'),
(7, 1, 'dsfsadwsad', '<p>dsadsadsad</p>', 'rwesr', 'draft', '2024-10-01 17:44:04', '2024-10-02 12:05:14'),
(8, 1, 'dsfds', '&lt;pre&gt;sadsadsad&lt;/pre&gt;', 'sdasad', 'draft', '2024-10-01 18:13:46', '2024-10-02 12:05:14'),
(9, 1, 'fdf', '<p><span style=\"color: #ba372a;\">dfdsf</span></p>', 'fe465', 'published', '2024-10-01 18:31:28', '2024-10-02 13:10:48'),
(12, 2, 'wsadsad', '&lt;p&gt;dssad&lt;/p&gt;', 'dsad', 'draft', '2024-10-02 12:42:01', '2024-10-02 12:43:22'),
(15, 6, 'sadsad', '<p><span style=\"text-decoration: underline;\">sadsad</span></p>', 'sdasad', 'published', '2024-10-02 13:03:03', '2024-10-02 13:09:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
