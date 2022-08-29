-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2022 at 02:37 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siwes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `ID` int(5) NOT NULL,
  `reg_num` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  `dept` varchar(100) NOT NULL,
  `siwes_place` varchar(300) NOT NULL,
  `siwes_supervisor` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL,
  `photo` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`ID`, `reg_num`, `password`, `fullname`, `email`, `address`, `state`, `dept`, `siwes_place`, `siwes_supervisor`, `status`, `photo`) VALUES
(2, '18/1274', '123456789', 'IDUMU DEBORAH TOYOSI', 'idumu@gmail.com', '67 Uwanse rd, ', 'Cross River', 'Computer Science', 'Leastpay Tech Services, Uyo', '3', '1', 'uploadImage/a7.jpg'),
(3, '18/132025', '12345678', 'Nwankwoala Bishop Joel', 'joel2019@gmail.com', '45 Atu rd, calabar', 'Cross River', 'Computer Science', 'Leastpay Solutions Ltd, Uyo', '49', '1', 'uploadImage/default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
