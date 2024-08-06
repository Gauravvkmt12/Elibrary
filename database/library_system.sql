-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 01:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `author2`
--

CREATE TABLE `author2` (
  `id` int(15) NOT NULL,
  `Author_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author2`
--

INSERT INTO `author2` (`id`, `Author_name`) VALUES
(1, 'Sanjeev Joshi'),
(2, 'Arup Kumar'),
(3, 'Manorama Mishra'),
(5, 'Sanjeev Sanyal'),
(6, 'William Shakespeare'),
(7, 'Danielle Steel'),
(8, 'Agatha Christie'),
(10, 'J. K. Rowling'),
(28, 'Sanjeev'),
(43, 'gaurav kumawat'),
(52, 'Nathaniel Philbrick');

-- --------------------------------------------------------

--
-- Table structure for table `book2`
--

CREATE TABLE `book2` (
  `id` int(25) NOT NULL,
  `Book_Name` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Publisher` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book2`
--

INSERT INTO `book2` (`id`, `Book_Name`, `Category`, `Author`, `Publisher`) VALUES
(1, 'Little Women', '8', '3', '1'),
(2, 'In the Heart of the Sea', '15', '52', '14'),
(3, 'The Adventures of Tom Sawyer', '2', '3', '5'),
(4, 'When Breath Becomes Air', '6', '10', '2'),
(5, 'Letting Go', '5', '7', '9'),
(6, 'Jane Eyre', '1', '6', '9'),
(7, 'Wuthering Heights', '1', '53', '7'),
(8, 'Letting Go', '2', '3', '9');

-- --------------------------------------------------------

--
-- Table structure for table `bookissue2`
--

CREATE TABLE `bookissue2` (
  `id` int(25) NOT NULL,
  `Student_Name` varchar(50) NOT NULL,
  `Book_Name` varchar(50) NOT NULL,
  `Phone` bigint(25) NOT NULL,
  `Email` varchar(25) NOT NULL,
  `Issue_Date` date NOT NULL,
  `Return_Date` date NOT NULL,
  `Status` varchar(50) NOT NULL,
  `condition2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookissue2`
--

INSERT INTO `bookissue2` (`id`, `Student_Name`, `Book_Name`, `Phone`, `Email`, `Issue_Date`, `Return_Date`, `Status`, `condition2`) VALUES
(3, '2', '2', 0, '', '2024-05-15', '2024-05-07', 'Y', ''),
(4, '3', '1', 0, '', '2024-05-01', '2024-05-10', 'N', ''),
(6, '5', '6', 0, '', '2024-04-01', '2024-05-15', 'N', ''),
(17, '3', '3', 0, '', '2024-05-17', '2024-06-17', 'Y', ''),
(18, '', '', 0, '', '0000-00-00', '0000-00-00', '', 'usefull'),
(19, '4', '4', 0, '', '2024-05-01', '2024-05-17', 'Y', ''),
(20, '4', '4', 0, '', '2024-05-01', '2024-05-17', 'N', 'not usefull');

-- --------------------------------------------------------

--
-- Table structure for table `categories3`
--

CREATE TABLE `categories3` (
  `id` int(30) NOT NULL,
  `category_name` varchar(170) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories3`
--

INSERT INTO `categories3` (`id`, `category_name`) VALUES
(1, 'horror'),
(2, 'Adventure'),
(3, 'Crime'),
(4, 'Fantasy'),
(5, 'Classics'),
(6, 'Romance'),
(7, 'Thriller '),
(8, 'Historical Fiction'),
(9, 'Biography '),
(10, 'Health & Fitness'),
(15, 'Detective and Mystery');

-- --------------------------------------------------------

--
-- Table structure for table `publisher2`
--

CREATE TABLE `publisher2` (
  `id` int(30) NOT NULL,
  `publisher_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher2`
--

INSERT INTO `publisher2` (`id`, `publisher_name`) VALUES
(1, 'Arihant publication	\r\n'),
(2, 'Pan Macmillan India	'),
(3, 'Scholastic India'),
(4, 'Adventure'),
(5, 'Cinnamon Teal\r\n'),
(6, 'Manohar'),
(7, 'Scholastic India'),
(8, 'HarperCollins India'),
(9, 'Pirates'),
(11, 'TCK Publishing'),
(14, 'Simon & Schuster');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `password` varchar(55) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` bigint(25) NOT NULL,
  `Address` text NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `username`, `Name`, `password`, `Email`, `Phone`, `Address`, `profile_picture`) VALUES
(8, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 1234567890, 'jaipur', 'uploads/default-profile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `regstudent2`
--

CREATE TABLE `regstudent2` (
  `id` int(25) NOT NULL,
  `StudentName` varchar(50) NOT NULL,
  `Gender` varchar(25) NOT NULL,
  `Phone` bigint(25) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regstudent2`
--

INSERT INTO `regstudent2` (`id`, `StudentName`, `Gender`, `Phone`, `Email`) VALUES
(1, 'Christine T Lynch', 'Male', 6172916918, '7uvlq521v3j@tempmail.net'),
(2, 'Alan C Dugan	', 'Male	', 2605304242, 'vzoqgqip3nf@tempmail.net'),
(3, 'Derek C Cascio	', 'Male	', 8016735825, 'o3o9ins8q1@tempmail.net'),
(4, 'Maria D Hughes	', 'Male', 8703710686, 'i7ooslzwsvm@tempmail.net'),
(5, 'Joyce R Craig	', 'Female	', 2107869036, '4otic2rvdzv@tempmail.net'),
(6, 'gaurav', 'Male', 9874563222, 'gaurav@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `settings2`
--

CREATE TABLE `settings2` (
  `id` int(50) NOT NULL,
  `return_days` int(50) NOT NULL,
  `fine` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings2`
--

INSERT INTO `settings2` (`id`, `return_days`, `fine`) VALUES
(1, 17, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author2`
--
ALTER TABLE `author2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book2`
--
ALTER TABLE `book2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookissue2`
--
ALTER TABLE `bookissue2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories3`
--
ALTER TABLE `categories3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publisher2`
--
ALTER TABLE `publisher2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regstudent2`
--
ALTER TABLE `regstudent2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings2`
--
ALTER TABLE `settings2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author2`
--
ALTER TABLE `author2`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `book2`
--
ALTER TABLE `book2`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookissue2`
--
ALTER TABLE `bookissue2`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories3`
--
ALTER TABLE `categories3`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `publisher2`
--
ALTER TABLE `publisher2`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `regstudent2`
--
ALTER TABLE `regstudent2`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `settings2`
--
ALTER TABLE `settings2`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
