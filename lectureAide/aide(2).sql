-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2024 at 08:14 PM
-- Server version: 10.11.6-MariaDB-2
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aide`
--

-- --------------------------------------------------------

CREATE database `aide`;
use `aide`;
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `comp_id` int(11) NOT NULL,
  `comp_name` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `weight` decimal(3,2) NOT NULL,
  `max` int(11) NOT NULL,
  `configured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`comp_id`, `comp_name`, `date`, `course_id`, `weight`, `max`, `configured`) VALUES
(5, 'Quiz 2', '2024-03-23', 'IIT2205', 0.30, 30, 1),
(6, 'Test 1', '2024-03-23', 'IIT2205', 0.30, 25, 1),
(7, 'lab 1', '2024-03-23', 'IIT2205', 0.30, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseid` varchar(50) NOT NULL,
  `c_name` varchar(75) NOT NULL,
  `LecturerEmail` varchar(50) NOT NULL,
  `Year` year(4) NOT NULL,
  `Part` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `c_name`, `LecturerEmail`, `Year`, `Part`) VALUES
('IIT2205', 'Php', 'Samar@it', '2024', '2.2'),
('IIT2203', 'MIB', 'ruvimbo@it', '2023', '2.1'),
('IIT2204', 'SAAD', 'ruvimbo@it', '2023', '2.1'),
('IIT2201', 'data structures', 'ruvimbo@it', '2023', '2.2'),
('CIS2201', 'database management systems', 'samar@it', '2024', '2.1'),
('ISA2201', 'cryptography', 'samar@it', '2024', '2.1'),
('TEC2201', 'TEC', 'talent@it', '2024', '2.1'),
('IIT2206', 'stats', 'talent@it', '2024', '2.1'),
('IIT2322', 'data structure', 'samar@it', '2024', '2.2');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `reg` varchar(30) NOT NULL,
  `id` int(50) NOT NULL,
  `comp_id` int(50) NOT NULL,
  `mark` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`reg`, `id`, `comp_id`, `mark`) VALUES
('h220525x', 1, 9, 34),
('h220', 2, 9, 8),
('h220179t', 3, 9, 878),
('h220', 4, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `reg` varchar(50) NOT NULL,
  `program` varchar(10) NOT NULL,
  `period` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`name`, `surname`, `reg`, `program`, `period`) VALUES
('confidence', 'mataka', 'h220', 'IIT', '22-26'),
('Marvelous', 'sadomba', 'h220179t', 'IIT', '22-26'),
('talent', 'gaviro', 'h2202', 'IIT', '22-26'),
('ruvimbo', 'tagara', 'h220525x', 'IIT', '22-26');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `points` int(11) NOT NULL,
  `date` date NOT NULL,
  `c_id` varchar(10) NOT NULL,
  `l_email` varchar(50) NOT NULL,
  `type` varchar(30) NOT NULL,
  `configured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `title`, `points`, `date`, `c_id`, `l_email`, `type`, `configured`) VALUES
(1, 'test 1', 25, '2024-03-24', 'IIT2202', 'samar@it', 'test', 1),
(2, 'test 2', 30, '2024-03-26', 'IIT2203', 'samar@it', 'test', 1),
(3, 'assign 1', 25, '2024-03-28', 'IIT2205', 'samar@it', 'assignment', 1),
(4, 'test 1', 25, '2024-03-26', 'IIT2203', 'samar@it', 'test', 1),
(5, 'test 1', 25, '2024-03-29', 'IIT2205', 'samar@it', 'test', 1),
(6, 'test 1', 25, '2024-03-28', 'ISA2201', 'samar@it', 'test', 1),
(8, 'test 2', 25, '2024-04-12', 'IIT2205', 'samar@it', 'test', 1),
(9, 'assignment 1', 25, '2024-04-12', 'CIS2201', 'samar@it', 'assignment', 1),
(10, 'Ass2', 30, '2024-04-10', 'IIT2205', 'samar@it', 'assignment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `names` varchar(70) NOT NULL,
  `email` varchar(75) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `school` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `names`, `email`, `role`, `password`, `school`) VALUES
(1, 'Ruvimbo Tagara', 'ruvimbo@it', 'lecturer', '4f1aa054ed83438ae649d6ed26902f82', 'IST'),
(3, 'Marvelous Sadomba', 'samar@it', 'admin', '4f1aa054ed83438ae649d6ed26902f82', NULL),
(4, 'Talent Gaviro', 'talent@it', 'dept_chair', '4d3debafdd402130036512d2af7f3661', 'IST'),
(5, 'Confidence Mataka', 'conie@it', 'exam_chair', 'e89b9f1a799ad733e970d3ff8921593a', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseid`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`reg`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
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
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
