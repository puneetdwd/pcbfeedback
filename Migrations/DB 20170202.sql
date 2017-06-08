-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2017 at 07:54 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sqim`
--

-- --------------------------------------------------------

--
-- Table structure for table `foolproofs`
--

CREATE TABLE IF NOT EXISTS `foolproofs` (
`id` int(11) NOT NULL,
  `org_checkpoint_id` int(11) NOT NULL,
  `stage` varchar(100) NOT NULL,
  `sub_stage` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `major_control_parameters` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lsl` varchar(10) DEFAULT NULL,
  `usl` varchar(10) DEFAULT NULL,
  `tgt` varchar(10) DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `measuring_equipment` varchar(255) NOT NULL,
  `cycle` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `all_values` text,
  `all_results` text,
  `result` enum('OK','NG','NP') DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foolproofs`
--
ALTER TABLE `foolproofs`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foolproofs`
--
ALTER TABLE `foolproofs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
