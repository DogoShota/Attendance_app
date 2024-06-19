-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-18 05:22:35
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `attendance_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `attendance_value` float DEFAULT NULL,
  `count` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `class_name`, `attendance_date`, `status`, `student_name`, `attendance_value`, `count`) VALUES
(23, '214016', '卒論', '2024-06-12', '', NULL, NULL, 0.3),
(24, '214016', '卒論', '2024-06-15', '遅刻', NULL, NULL, 0.3),
(25, '214016', '卒論', '2024-06-13', '', NULL, NULL, 1.0),
(26, '214016', '卒論', '2024-06-05', '', NULL, NULL, 1.0),
(27, '214016', '卒論', '2024-06-11', '', NULL, NULL, 1.0),
(28, '214016', '卒論', '2024-06-01', '', NULL, NULL, 0.3);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(5, 'admin', '$2y$10$HWlpVOnHzEROzGCqR0MB.OIVSrd/9Itf4BZ9Uvc7UTM.QD56.Vq.K', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
