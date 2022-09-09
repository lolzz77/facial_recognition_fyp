-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 08:04 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `face_recognition`
--
CREATE DATABASE IF NOT EXISTS `face_recognition` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `face_recognition`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `user_id` varchar(15) NOT NULL COMMENT 'username',
  `password` int(10) UNSIGNED NOT NULL COMMENT 'password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(10) NOT NULL,
  `first_n` varchar(15) NOT NULL,
  `middle_n` varchar(15) DEFAULT NULL,
  `last_n` varchar(15) DEFAULT NULL,
  `position` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `flag`
--

CREATE TABLE `flag` (
  `no` int(255) UNSIGNED NOT NULL,
  `date` date NOT NULL COMMENT 'date for the flag',
  `emp_id` int(10) NOT NULL COMMENT 'employee id',
  `shift` varchar(10) NOT NULL COMMENT 'morning/afternoon/full day shift'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `emp_id` int(10) DEFAULT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(10) NOT NULL COMMENT 'notice id',
  `date` date NOT NULL COMMENT 'date generated',
  `notice` longtext NOT NULL COMMENT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `pay_id` int(10) NOT NULL COMMENT 'payroll id',
  `emp_id` int(10) NOT NULL COMMENT 'employee id ',
  `pay_date` date NOT NULL COMMENT 'payroll date',
  `pay_amount` int(11) NOT NULL COMMENT 'payroll amount'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position` varchar(25) NOT NULL COMMENT 'e.g Supervisor, Assistant Supervisor, Trainer',
  `salary` int(6) UNSIGNED NOT NULL COMMENT 'Salary for the position'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position`, `salary`) VALUES
('assistant supervisor', 2000),
('edp clerk', 1500),
('general worker', 1500),
('supervisor', 2500),
('training supervisor', 2200);

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `m_start` time NOT NULL COMMENT 'Morning Shift, start time',
  `m_break_s` time NOT NULL,
  `m_break_e` time NOT NULL,
  `m_end` time NOT NULL,
  `a_start` time NOT NULL,
  `a_break_s` time NOT NULL,
  `a_break_e` time NOT NULL,
  `a_end` time NOT NULL,
  `f_start` time NOT NULL,
  `f_break1_s` time NOT NULL,
  `f_break1_e` time NOT NULL,
  `f_break2_s` time NOT NULL,
  `f_break2_e` time NOT NULL,
  `f_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `timestamp`
--

CREATE TABLE `timestamp` (
  `date` date NOT NULL,
  `emp_id` int(10) NOT NULL,
  `t_morning` time DEFAULT NULL,
  `t_afternoon_break` time DEFAULT NULL,
  `t_afternoon` time DEFAULT NULL,
  `t_evening_break` time DEFAULT NULL,
  `t_evening` time DEFAULT NULL,
  `t_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `work_shift`
--

CREATE TABLE `work_shift` (
  `shift_name` varchar(20) NOT NULL,
  `morning_time` time DEFAULT NULL,
  `afternoon_break` time DEFAULT NULL,
  `afternoon_time` time DEFAULT NULL,
  `evening_break` time DEFAULT NULL,
  `evening_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_shift`
--

INSERT INTO `work_shift` (`shift_name`, `morning_time`, `afternoon_break`, `afternoon_time`, `evening_break`, `evening_time`) VALUES
('afternoon_shift', NULL, NULL, '12:30:00', '16:00:00', '17:00:00'),
('full_shift', '08:00:00', '12:30:00', '13:30:00', '16:00:00', '17:00:00'),
('morning_shift', '08:00:00', '12:30:00', '13:30:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `emp_pos_fk` (`position`);

--
-- Indexes for table `flag`
--
ALTER TABLE `flag`
  ADD PRIMARY KEY (`no`),
  ADD KEY `flag_emp_id_fk` (`emp_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD KEY `img_emp_id_fk` (`emp_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `pay_emp_id_fk` (`emp_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position`);

--
-- Indexes for table `timestamp`
--
ALTER TABLE `timestamp`
  ADD PRIMARY KEY (`date`,`emp_id`),
  ADD KEY `time_emp_id_fk` (`emp_id`);

--
-- Indexes for table `work_shift`
--
ALTER TABLE `work_shift`
  ADD PRIMARY KEY (`shift_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flag`
--
ALTER TABLE `flag`
  MODIFY `no` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flag`
--
ALTER TABLE `flag`
  ADD CONSTRAINT `flag_emp_id_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `img_emp_id_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `pay_emp_id_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);

--
-- Constraints for table `timestamp`
--
ALTER TABLE `timestamp`
  ADD CONSTRAINT `time_emp_id_fk` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
