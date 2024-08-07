-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 07, 2024 at 08:55 AM
-- Server version: 10.8.4-MariaDB-log
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galery`
--

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`id`, `name`, `parent_id`, `user_id`) VALUES
(18, 'Котики', NULL, 31);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(40) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `name`, `format`, `path`, `view_count`) VALUES
(27, '1646793778_1-kartinkin-net-p-milii-kotik-kartinki-1', 'jpg', 'upload/4070bce8868c3cc95038c84b2138b512.jpg', 3),
(28, '1646793808_4-kartinkin-net-p-milii-kotik-kartinki-4', 'jpg', 'upload/236ba1460770b03d41089f0b62a7a19f.jpg', 2),
(29, '1646793733_7-kartinkin-net-p-milii-kotik-kartinki-7', 'jpg', 'upload/26639787da790615d7cc159d5c8b0149.jpg', 1),
(30, '1646793749_11-kartinkin-net-p-milii-kotik-kartinki-11', 'jpg', 'upload/968f4507746a69a39cac04762b3450f5.jpg', 1),
(31, '1646793730_13-kartinkin-net-p-milii-kotik-kartinki-13', 'jpg', 'upload/c86cf18166973f03b5f53fb629e84deb.jpg', 0),
(32, '1646793752_22-kartinkin-net-p-milii-kotik-kartinki-23', 'jpg', 'upload/4cb5788b86c405f7649ac7e43a521c4c.jpg', 0),
(33, '1646793756_35-kartinkin-net-p-milii-kotik-kartinki-36', 'jpg', 'upload/1ad8883d1d114d7cb9f8050c65ad3ccb.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `image_collection`
--

CREATE TABLE `image_collection` (
  `image_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_collection`
--

INSERT INTO `image_collection` (`image_id`, `collection_id`) VALUES
(28, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) NOT NULL,
  `fistname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fistname`, `surname`, `username`, `email`, `password`, `status`) VALUES
(30, 'Миша', 'Тест', 'Михан123', 'test1233@mail.ru', '$2y$10$Uw7ZkvilYu9c3c8rzZNeyeeO4SDT9ywrsPBXjiWtDhnHuDvvlhcZW', 'NULL'),
(31, 'Гость', 'Тест', 'Гость', 'test13@mail.ru', '$2y$10$vl0Vz9vM5w1nRVrsjQqXoO6MhqqpC4YG3iYf65ZD3nKLe.TEMPX5G', 'NULL'),
(32, 'Гость1', 'Тест', 'Гость1', 'test0@mail.ru', '$2y$10$tphXDGGcQUr3C9dOWKgBDe6r9Q7GODOhHJKGbeQV0tY6QORdd4OnW', NULL),
(33, 'Гость3', 'Тест', 'Гость3', 'test33@mail.ru', '$2y$10$AnTmYG7vwb5I5oKfH1BnI.urk8T1xEf4dH9et8RYH.q5jkbe/GR.e', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
