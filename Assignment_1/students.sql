-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 06:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `rollNumber` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `dateOfBirth` varchar(255) NOT NULL,
  `fatherName` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`rollNumber`, `name`, `session`, `dateOfBirth`, `fatherName`, `class`) VALUES
(21, 'test', '2039-1290', '23/10/5000', 'Mr x', 'x'),
(45, 'name', '839-192', '45/29/9021', 'X', 'IV'),
(1192568, 'Shubham', '2019-2023', '10/05/2000', 'Sultan Siwach', 'IX');

-- --------------------------------------------------------

--
-- Table structure for table `subjectmarks`
--

CREATE TABLE `subjectmarks` (
  `rollNumber` int(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `totalMarks` int(3) NOT NULL DEFAULT 100,
  `passingMarks` int(3) NOT NULL DEFAULT 33,
  `marksObtained` int(3) NOT NULL,
  `grade` varchar(1) NOT NULL DEFAULT 'F'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjectmarks`
--

INSERT INTO `subjectmarks` (`rollNumber`, `subject`, `totalMarks`, `passingMarks`, `marksObtained`, `grade`) VALUES
(1192568, 'English', 100, 33, 70, 'A'),
(1192568, 'Hindi', 100, 33, 90, 'B'),
(1192568, 'Math', 100, 33, 45, 'D'),
(1192568, 'Music', 100, 33, 100, 'A'),
(21, 'English', 100, 33, 90, 'F'),
(21, 'Hindi', 100, 33, 100, 'A'),
(45, 'CS', 100, 33, 100, 'A'),
(45, 'Networking', 100, 33, 100, 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`rollNumber`);

--
-- Indexes for table `subjectmarks`
--
ALTER TABLE `subjectmarks`
  ADD KEY `rollNumber` (`rollNumber`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjectmarks`
--
ALTER TABLE `subjectmarks`
  ADD CONSTRAINT `subjectmarks_ibfk_1` FOREIGN KEY (`rollNumber`) REFERENCES `students` (`rollNumber`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
