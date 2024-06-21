-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2024 at 01:23 AM
-- Server version: 10.6.16-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `link`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`c_id`, `c_name`, `c_status`) VALUES
(1, 'MCA DIV 3/4/5', 1),
(2, 'MCA 6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reschedules`
--

CREATE TABLE `reschedules` (
  `rs_id` int(11) NOT NULL,
  `rs_class` int(11) NOT NULL,
  `rs_day` int(11) NOT NULL,
  `rs_rank` int(11) NOT NULL,
  `rs_subject` int(11) DEFAULT NULL,
  `rs_note` varchar(255) NOT NULL,
  `rs_color` varchar(255) NOT NULL,
  `rs_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reschedules`
--

INSERT INTO `reschedules` (`rs_id`, `rs_class`, `rs_day`, `rs_rank`, `rs_subject`, `rs_note`, `rs_color`, `rs_status`) VALUES
(9, 2, 0, 2, 4, 'Fecture', '#0b85fe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `s_id` int(11) NOT NULL,
  `s_subject` varchar(100) NOT NULL,
  `s_faculty` varchar(100) NOT NULL,
  `s_short` varchar(20) NOT NULL,
  `s_link` varchar(100) NOT NULL,
  `s_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`s_id`, `s_subject`, `s_faculty`, `s_short`, `s_link`, `s_status`) VALUES
(1, 'Java Programming', 'Prof. Vivek Dave', 'JAVA-VD', 'https://meet.google.com/ckw-frhh-gqd', 1),
(2, 'Data Structures', 'Dr. Priya Swaminarayan', 'DS-PS', 'https://meet.google.com/dcz-ngrp-kef', 1),
(3, 'Data Structures', 'Prof. Jigar Bhavsar', 'DS-JB', 'https://meet.google.com/wfh-xwif-ohg', 1),
(4, 'Open Source Technology using PHP', 'Prof. Kaushal Gor', 'OSTP-KG', 'https://meet.google.com/pbz-hatm-ipj', 1),
(5, 'Advanced DBMS', 'Prof. Alka Choks', 'ADBMS-AC', 'https://meet.google.com/vxd-ggbi-upg', 1),
(6, 'Software Engineering', 'Prof. Deepak Agrawal', 'SE-DA', 'https://meet.google.com/jgo-ksge-odi', 1),
(7, 'Communication & Programming Skills', 'Prof. Bindi Bhatt', 'CPS-BB', 'https://meet.google.com/waz-dpab-ubb', 1),
(8, 'Communication & Programming Skills', 'FACE', 'CPS-FACE', 'http://meet.google.com/ovy-xabd-fnq', 1),
(9, 'Object Oriented Programming', 'Prof. Jigar Bhavsar', 'OOP-JB', 'http://meet.google.com/nfq-wffw-usv', 1),
(10, 'DBMS', 'Prof. Alka Choksi', 'DBMS-AC', 'http://meet.google.com/vxd-ggbi-upg', 1),
(11, 'C', 'Prof. Vivek Dave', 'C-VD', 'https://meet.google.com/nkd-juej-qiy', 1),
(12, 'HTML', 'Prof. Kaushal Gor', 'HTML-KG', 'https://meet.google.com/xvs-ehvp-ffg', 1),
(13, 'Fundamentals of Computer Organization', 'Prof. Deepak Agrawal', 'FCO-DA', 'https://meet.google.com/uqf-xikw-eap', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `tt_id` int(11) NOT NULL,
  `tt_class` int(11) NOT NULL,
  `tt_day` int(11) NOT NULL,
  `tt_rank` int(11) NOT NULL,
  `tt_subject` int(11) DEFAULT NULL,
  `tt_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`tt_id`, `tt_class`, `tt_day`, `tt_rank`, `tt_subject`, `tt_status`) VALUES
(1, 1, 0, 0, 3, 1),
(2, 1, 0, 1, 5, 1),
(3, 1, 0, 2, 7, 1),
(4, 1, 0, 3, 4, 1),
(5, 1, 1, 0, 8, 1),
(6, 1, 1, 1, 6, 1),
(7, 1, 1, 2, 3, 1),
(8, 1, 1, 3, 4, 1),
(9, 1, 2, 0, 3, 1),
(10, 1, 2, 1, 4, 1),
(11, 1, 2, 2, 5, 1),
(12, 1, 2, 3, 1, 1),
(13, 1, 3, 0, 6, 1),
(14, 1, 3, 1, 7, 1),
(15, 1, 3, 2, 5, 1),
(16, 1, 3, 3, 1, 1),
(17, 1, 4, 0, 4, 1),
(18, 1, 4, 1, 1, 1),
(19, 1, 4, 2, 5, 1),
(20, 1, 4, 3, 6, 1),
(21, 1, 5, 0, 6, 1),
(22, 1, 5, 1, 2, 1),
(23, 1, 5, 2, 8, 1),
(24, 1, 5, 3, 3, 1),
(25, 2, 0, 0, 1, 1),
(26, 2, 0, 1, 1, 1),
(27, 2, 0, 2, 2, 1),
(28, 2, 0, 3, 5, 1),
(29, 2, 1, 0, 3, 1),
(30, 2, 1, 1, 5, 1),
(31, 2, 1, 2, 5, 1),
(32, 2, 1, 3, 10, 1),
(33, 2, 2, 0, 8, 1),
(34, 2, 2, 1, 6, 1),
(35, 2, 2, 2, 3, 1),
(36, 2, 2, 3, 8, 1),
(37, 2, 3, 0, 4, 1),
(38, 2, 3, 1, 6, 1),
(39, 2, 3, 2, 6, 1),
(40, 2, 3, 3, 10, 1),
(41, 2, 4, 0, 5, 1),
(42, 2, 4, 1, 7, 1),
(43, 2, 4, 2, 8, 1),
(44, 2, 4, 3, NULL, 1),
(45, 2, 5, 0, 4, 1),
(46, 2, 5, 1, 6, 1),
(47, 2, 5, 2, 1, 1),
(48, 2, 5, 3, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `v_id` int(11) NOT NULL,
  `v_date` varchar(255) NOT NULL,
  `v_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`v_id`, `v_date`, `v_status`) VALUES
(1, 'A20240622', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `reschedules`
--
ALTER TABLE `reschedules`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`tt_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reschedules`
--
ALTER TABLE `reschedules`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
