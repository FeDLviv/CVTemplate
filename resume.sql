-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Лис 13 2017 р., 19:45
-- Версія сервера: 10.1.26-MariaDB
-- Версія PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `resume`
--
CREATE DATABASE IF NOT EXISTS `resume` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `resume`;

-- --------------------------------------------------------

--
-- Структура таблиці `education`
--

CREATE TABLE `education` (
  `id` int(10) UNSIGNED NOT NULL,
  `institute` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `speciality` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `start` date NOT NULL,
  `stop` date DEFAULT NULL,
  `dateChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `education`
--

INSERT INTO `education` (`id`, `institute`, `title`, `speciality`, `specialization`, `start`, `stop`, `dateChange`) VALUES
(1, 'Vinnytsia National Technical University', 'Institute for power engineering, ecology and electrical mechanics', 'Electric stations', 'Computerization of electrical equipment', '2002-09-01', '2007-06-30', '2017-11-12 14:14:55'),
(2, 'STEP Computer Academy', 'Software development', NULL, NULL, '2015-11-13', NULL, '2017-11-12 14:26:29');

-- --------------------------------------------------------

--
-- Структура таблиці `language`
--

CREATE TABLE `language` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` enum('Native','Advanced','Upper-Intermediate','Intermediate','Pre-Intermediate','Elementary') NOT NULL,
  `dateChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `language`
--

INSERT INTO `language` (`id`, `name`, `level`, `dateChange`) VALUES
(1, 'Ukrainian ', 'Native', '2017-11-11 20:06:58'),
(2, 'Russian ', 'Advanced', '2017-11-11 20:07:11'),
(3, 'English', 'Elementary', '2017-11-11 20:07:22');

-- --------------------------------------------------------

--
-- Структура таблиці `skill`
--

CREATE TABLE `skill` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('os','technologie','database','language') NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` enum('Advanced','Upper-Intermediate','Intermediate','Pre-Intermediate','Elementary','Basics') NOT NULL,
  `dateChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `skill`
--

INSERT INTO `skill` (`id`, `type`, `name`, `level`, `dateChange`) VALUES
(1, 'language', 'Java SE', 'Intermediate', '2017-11-11 18:47:25'),
(2, 'language', 'C#', 'Intermediate', '2017-11-11 18:47:40'),
(3, 'language', 'PHP', 'Intermediate', '2017-11-11 18:47:49'),
(4, 'language', 'JavaScript', 'Pre-Intermediate', '2017-11-11 18:48:06'),
(5, 'language', 'C/C++', 'Basics', '2017-11-11 18:48:16'),
(6, 'database', 'MySQL', 'Intermediate', '2017-11-11 18:48:39'),
(7, 'database', 'Microsoft SQL Server', 'Pre-Intermediate', '2017-11-11 18:48:58'),
(8, 'database', 'SQLite', 'Pre-Intermediate', '2017-11-11 18:49:21'),
(9, 'technologie', 'JDBC', 'Intermediate', '2017-11-11 18:49:37'),
(10, 'technologie', 'Swing', 'Intermediate', '2017-11-11 18:49:51'),
(11, 'technologie', 'JavaFX 2.2', 'Elementary', '2017-11-11 18:50:42'),
(12, 'technologie', 'WinForms', 'Pre-Intermediate', '2017-11-11 18:51:07'),
(13, 'technologie', 'WPF', 'Pre-Intermediate', '2017-11-11 18:51:25'),
(14, 'technologie', 'ADO.NET', 'Intermediate', '2017-11-11 18:52:00'),
(15, 'technologie', 'Entity Framework ', 'Intermediate', '2017-11-11 18:51:57'),
(16, 'technologie', 'WCF', 'Elementary', '2017-11-11 18:52:13'),
(17, 'technologie', 'HTML', 'Intermediate', '2017-11-11 18:52:26'),
(18, 'technologie', 'CSS', 'Intermediate', '2017-11-11 18:52:40'),
(19, 'technologie', 'Bootstrap', 'Intermediate', '2017-11-11 18:52:49'),
(20, 'technologie', 'LESS', 'Basics', '2017-11-11 18:53:03'),
(21, 'technologie', 'jQuery', 'Pre-Intermediate', '2017-11-11 18:53:15'),
(22, 'technologie', 'AngularJS', 'Pre-Intermediate', '2017-11-11 18:53:27'),
(23, 'technologie', 'WordPress', 'Elementary', '2017-11-11 18:53:43'),
(24, 'technologie', 'CodeIgniter', 'Pre-Intermediate', '2017-11-11 18:54:03'),
(25, 'technologie', 'Git', 'Pre-Intermediate', '2017-11-11 18:54:26'),
(26, 'technologie', 'Eclipse', 'Intermediate', '2017-11-11 18:54:41'),
(27, 'technologie', 'Microsoft Visual Studio', 'Intermediate', '2017-11-11 18:55:21'),
(28, 'technologie', 'Microsoft Studio Code', 'Intermediate', '2017-11-11 18:55:45'),
(29, 'technologie', 'Navicat', 'Intermediate', '2017-11-11 18:55:56'),
(30, 'os', 'Microsoft Windows', 'Intermediate', '2017-11-11 18:56:15'),
(31, 'os', 'Ubuntu GNU/Linux', 'Intermediate', '2017-11-11 18:56:38');

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'root', '$2y$10$MIZpRf2JBMObhTMQYSohEebqJuTIcDf6n7pf6smfrbmItjXh1EBoi');

-- --------------------------------------------------------

--
-- Структура таблиці `work`
--

CREATE TABLE `work` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisation` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `start` date NOT NULL,
  `stop` date DEFAULT NULL,
  `dateChange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `work`
--

INSERT INTO `work` (`id`, `organisation`, `position`, `start`, `stop`, `dateChange`) VALUES
(1, 'Lvivteploenergo', 'Engineer', '2012-12-06', NULL, '2017-11-12 14:08:48');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UN` (`name`);

--
-- Індекси таблиці `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `education`
--
ALTER TABLE `education`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `language`
--
ALTER TABLE `language`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблиці `work`
--
ALTER TABLE `work`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
