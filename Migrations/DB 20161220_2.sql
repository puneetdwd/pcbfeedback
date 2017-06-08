-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2016 at 04:31 PM
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
-- Table structure for table `inspection_config`
--

CREATE TABLE IF NOT EXISTS `inspection_config` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `checkpoint_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `sampling_type` varchar(50) NOT NULL,
  `inspection_level` varchar(10) DEFAULT NULL,
  `acceptable_quality` varchar(10) DEFAULT NULL,
  `aql` varchar(10) DEFAULT NULL,
  `lot_qty` varchar(10) DEFAULT NULL,
  `no_of_months` varchar(20) DEFAULT NULL,
  `no_of_times` smallint(4) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inspection_config`
--
ALTER TABLE `inspection_config`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inspection_config`
--
ALTER TABLE `inspection_config`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
