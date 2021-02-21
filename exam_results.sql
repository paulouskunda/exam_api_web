-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2021 at 12:02 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_results`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`) VALUES
(1, 'kas', '12345', 'Kas Kas');

-- --------------------------------------------------------

--
-- Table structure for table `past_papers`
--

CREATE TABLE `past_papers` (
  `pp_id` int(11) NOT NULL,
  `paper_name` varchar(50) NOT NULL,
  `paper_year` int(11) NOT NULL,
  `paper_url` varchar(50) NOT NULL,
  `paper_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `past_papers`
--

INSERT INTO `past_papers` (`pp_id`, `paper_name`, `paper_year`, `paper_url`, `paper_count`) VALUES
(1, 'English', 2019, './english_2019.pdf', 1),
(2, 'Mathematics', 2018, './math_2019.pdf', 30),
(3, 'Mathematics', 2019, 'Mathematics-2019.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pupils_accounts`
--

CREATE TABLE `pupils_accounts` (
  `id` int(11) NOT NULL,
  `pupil_id` varchar(50) NOT NULL,
  `pupil_password` varchar(100) NOT NULL,
  `pupil_school` varchar(50) NOT NULL,
  `pupil_intake` varchar(4) NOT NULL,
  `pupil_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pupils_accounts`
--

INSERT INTO `pupils_accounts` (`id`, `pupil_id`, `pupil_password`, `pupil_school`, `pupil_intake`, `pupil_name`) VALUES
(1, '20200105', '123456', '1030001', '2020', 'Kasolo Mambwe'),
(2, '20201', '1234', 'aci', '2014', 'Paul Kunda'),
(3, '201900105', '123456', '', '2019', 'Paul Kunda'),
(4, '201400105', '123456', '1002001', '2014', 'Mwaba');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `r_id` int(11) NOT NULL,
  `pupil_id_num` int(11) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_grade` int(11) NOT NULL,
  `intake` int(11) NOT NULL,
  `school_center` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`r_id`, `pupil_id_num`, `subject_name`, `subject_grade`, `intake`, `school_center`) VALUES
(1, 20200105, 'Mathematics', 1, 2020, 1030001),
(2, 20200105, 'English', 1, 2020, 1030001),
(3, 20200105, 'Physics', 2, 2020, 1030001),
(4, 20200105, 'Chemistry', 1, 2020, 1030001),
(5, 20200105, 'Geography', 2, 2020, 1030001),
(6, 20200105, 'Metal Work', 1, 2020, 1030001),
(7, 20200105, 'Biology', 2, 2020, 1030001),
(8, 20200105, 'Accounts', 3, 2020, 1030001),
(9, 20200105, 'Mathematics', 1, 2019, 1030001),
(10, 20200105, 'English', 1, 2019, 1030001),
(11, 20200105, 'Physics', 2, 2019, 1030001),
(12, 20200105, 'Chemistry', 1, 2019, 1030001),
(13, 20200105, 'Geography', 2, 2019, 1030001),
(14, 20200105, 'Metal Work', 1, 2019, 1030001),
(15, 20200105, 'Biology', 2, 2019, 1030001),
(16, 20200105, 'Accounts', 3, 2019, 1030001),
(17, 20200105, 'Mathematics', 1, 2019, 1030001),
(18, 20200105, 'English', 1, 2019, 1030001),
(19, 20200105, 'Physics', 2, 2019, 1030001),
(20, 20200105, 'Chemistry', 1, 2019, 1030001),
(21, 20200105, 'Geography', 2, 2019, 1030001),
(22, 20200105, 'Metal Work', 1, 2019, 1030001),
(23, 20200105, 'Biology', 2, 2019, 1030001),
(24, 20200105, 'Accounts', 3, 2019, 1030001),
(25, 20200105, 'Mathematics', 1, 2019, 1030001),
(26, 20200105, 'English', 1, 2019, 1030001),
(27, 20200105, 'Physics', 2, 2019, 1030001),
(28, 20200105, 'Chemistry', 1, 2019, 1030001),
(29, 20200105, 'Geography', 2, 2019, 1030001),
(30, 20200105, 'Metal Work', 1, 2019, 1030001),
(31, 20200105, 'Biology', 2, 2019, 1030001),
(32, 20200105, 'Accounts', 3, 2019, 1030001);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `school_center` int(11) DEFAULT NULL,
  `school_name` varchar(50) NOT NULL,
  `school_location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`school_center`, `school_name`, `school_location`) VALUES
(1030001, 'Matero Boys', 'LSK'),
(1002001, 'Pandemic Int\'l', 'LSK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `past_papers`
--
ALTER TABLE `past_papers`
  ADD PRIMARY KEY (`pp_id`);

--
-- Indexes for table `pupils_accounts`
--
ALTER TABLE `pupils_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD UNIQUE KEY `school_center` (`school_center`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `past_papers`
--
ALTER TABLE `past_papers`
  MODIFY `pp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pupils_accounts`
--
ALTER TABLE `pupils_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
