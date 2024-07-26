-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-07-26 03:14:20
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
  `class_name` varchar(100) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `count` decimal(3,1) NOT NULL,
  `remarks` text DEFAULT NULL,
  `student_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `attendance`
--

INSERT INTO `attendance` (`id`, `class_name`, `attendance_date`, `status`, `count`, `remarks`, `student_id`) VALUES
(87, '医事カルテ', '2024-07-03', '遅刻', 1.0, '頭痛が痛い', 'admin'),
(90, '卒論', '2024-07-01', '欠席', 1.0, '通院のため', '214016');

-- --------------------------------------------------------

--
-- テーブルの構造 `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`) VALUES
(1, '総合演習'),
(2, '卒論'),
(3, '企業活動'),
(4, 'テスト移行'),
(5, 'H/R');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `student_id`, `password`, `is_admin`) VALUES
(5, 'admin', '$2y$10$HWlpVOnHzEROzGCqR0MB.OIVSrd/9Itf4BZ9Uvc7UTM.QD56.Vq.K', 1),
(19, '214016', '$2y$10$npM7.lYaaXS6swC.NhADYOT0E2VEZfgemfBz1b5Syqk05yXZe.HCi', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- テーブルの AUTO_INCREMENT `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
