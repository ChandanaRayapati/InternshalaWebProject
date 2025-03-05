-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 06, 2020 at 08:17 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `expid` int(11) NOT NULL AUTO_INCREMENT,
  `planid` int(11) DEFAULT NULL,
  `titleexpense` varchar(25) DEFAULT NULL,
  `expdate` date DEFAULT NULL,
  `paidby` varchar(15) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `expfile` text DEFAULT NULL,
  PRIMARY KEY (`expid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expid`, `planid`, `titleexpense`, `expdate`, `paidby`, `amount`, `expfile`) VALUES
(1, 1, 'Bill1', '2020-07-01', 'Shiny', 480, ''),
(2, 1, 'Bill2', '2020-07-02', 'Ankith', 840, 'img/06-07-2020-1594066240.jpg'),
(3, 1, 'Bill3', '2020-07-02', 'Shiny', 1200, '');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `planid` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `title` varchar(20) NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `budget` int(11) NOT NULL,
  `peopleno` int(11) NOT NULL,
  `peoplename` varchar(350) NOT NULL,
  PRIMARY KEY (`planid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`planid`, `email`, `title`, `fromdate`, `todate`, `budget`, `peopleno`, `peoplename`) VALUES
(1, 'ankith@gmail.com', 'Groceries', '2020-07-01', '2020-07-02', 5000, 2, 'a:2:{i:0;s:6:\"Ankith\";i:1;s:5:\"Shiny\";}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `email` text NOT NULL,
  `pwd` text NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `email`, `pwd`, `mobile`, `gender`) VALUES
(1, 'Ankith', 'ankith@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9898788756', 'M'),
(2, 'Shiny', 'shiny@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8976567898', 'F');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
