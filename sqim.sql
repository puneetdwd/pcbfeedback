-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2016 at 08:23 AM
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
-- Table structure for table `audits`
--

CREATE TABLE IF NOT EXISTS `audits` (
`id` int(11) NOT NULL,
  `audit_date` date NOT NULL,
  `auditer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `part_no` varchar(150) NOT NULL,
  `part_name` varchar(150) NOT NULL,
  `prod_lot_qty` mediumint(8) NOT NULL,
  `state` enum('registered','aborted','started','finished','completed','paired') NOT NULL DEFAULT 'registered',
  `on_hold` tinyint(1) NOT NULL DEFAULT '0',
  `register_datetime` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `audit_date`, `auditer_id`, `supplier_id`, `product_id`, `part_id`, `part_no`, `part_name`, `prod_lot_qty`, `state`, `on_hold`, `register_datetime`, `created`, `modified`) VALUES
(2, '2016-12-22', 1, 4, 1, 1, 'P01', 'Part 1', 9, 'completed', 0, '2016-12-22 08:34:28', '2016-12-22 08:34:28', '2016-12-22 08:41:08'),
(3, '2016-12-22', 1, 4, 1, 1, 'P01', 'Part 1', 10, 'aborted', 0, '2016-12-22 10:53:24', '2016-12-22 10:53:24', '2016-12-22 11:41:04'),
(4, '2016-12-22', 1, 4, 1, 1, 'P01', 'Part 1', 1000, 'aborted', 0, '2016-12-22 11:41:53', '2016-12-22 11:41:53', '2016-12-22 11:52:10'),
(5, '2016-12-22', 1, 4, 1, 1, 'P01', 'Part 1', 1000, 'started', 0, '2016-12-22 11:56:17', '2016-12-22 11:56:17', '2016-12-22 11:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `audit_checkpoints`
--

CREATE TABLE IF NOT EXISTS `audit_checkpoints` (
`id` bigint(11) unsigned NOT NULL,
  `org_checkpoint_id` int(11) DEFAULT NULL,
  `audit_id` int(11) NOT NULL,
  `sampling_qty` smallint(4) NOT NULL,
  `checkpoint_no` smallint(4) NOT NULL,
  `insp_item` varchar(100) NOT NULL,
  `insp_item2` text NOT NULL,
  `insp_item3` text CHARACTER SET utf8 NOT NULL,
  `insp_item4` text,
  `spec` text CHARACTER SET utf8 NOT NULL,
  `lsl` varchar(10) NOT NULL,
  `usl` varchar(10) NOT NULL,
  `tgt` varchar(10) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `pointer` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(250) DEFAULT NULL,
  `all_values` text,
  `all_results` text,
  `result` enum('OK','NG','NA') DEFAULT NULL,
  `result_datetime` datetime DEFAULT NULL,
  `na_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_na` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_checkpoints`
--

INSERT INTO `audit_checkpoints` (`id`, `org_checkpoint_id`, `audit_id`, `sampling_qty`, `checkpoint_no`, `insp_item`, `insp_item2`, `insp_item3`, `insp_item4`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `pointer`, `remark`, `all_values`, `all_results`, `result`, `result_datetime`, `na_approved`, `is_na`, `created`, `modified`) VALUES
(15, 1, 2, 8, 1, 'ABCD', '', '', NULL, 'ABCD ABCD', '10', '20', '15', '5', 1, '                                    ', '2,3,4,6,3,7,5,4', 'NG,NG,NG,NG,NG,NG,NG,NG', 'NG', '2016-12-22 08:38:58', 0, 0, '2016-12-22 08:36:43', '2016-12-22 08:38:58'),
(16, 1, 3, 8, 1, 'ABCD', '', '', NULL, 'ABCD ABCD', '10', '20', '15', '5', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, '2016-12-22 10:53:35', NULL),
(17, 1, 5, 2, 1, 'ABCD', '', '', NULL, 'ABCD ABCD', '10', '20', '15', '5', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, '2016-12-22 11:56:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auto_code_acceptance_sample_mapping`
--

CREATE TABLE IF NOT EXISTS `auto_code_acceptance_sample_mapping` (
`id` int(11) NOT NULL,
  `code` varchar(2) NOT NULL,
  `acceptable_quality` varchar(10) NOT NULL,
  `no_of_samples` mediumint(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_code_acceptance_sample_mapping`
--

INSERT INTO `auto_code_acceptance_sample_mapping` (`id`, `code`, `acceptable_quality`, `no_of_samples`) VALUES
(1, 'A', '0.010', 1250),
(2, 'A', '0.015', 800),
(3, 'A', '0.025', 500),
(4, 'A', '0.040', 315),
(5, 'A', '0.065', 200),
(6, 'A', '0.10', 125),
(7, 'A', '0.15', 80),
(8, 'A', '0.25', 50),
(9, 'A', '0.40', 32),
(10, 'A', '0.65', 20),
(11, 'A', '1.0', 13),
(12, 'A', '1.5', 8),
(13, 'A', '2.5', 5),
(14, 'A', '4.0', 3),
(15, 'A', '6.5', 2),
(16, 'A', '10', 5),
(17, 'A', '15', 3),
(18, 'A', '25', 2),
(19, 'A', '40', 2),
(20, 'A', '65', 2),
(21, 'A', '100', 2),
(22, 'A', '150', 2),
(23, 'A', '250', 2),
(24, 'A', '400', 2),
(25, 'A', '650', 2),
(26, 'A', '1000', 2),
(27, 'B', '0.010', 1250),
(28, 'B', '0.015', 800),
(29, 'B', '0.025', 500),
(30, 'B', '0.040', 315),
(31, 'B', '0.065', 200),
(32, 'B', '0.10', 125),
(33, 'B', '0.15', 80),
(34, 'B', '0.25', 50),
(35, 'B', '0.40', 32),
(36, 'B', '0.65', 20),
(37, 'B', '1.0', 13),
(38, 'B', '1.5', 8),
(39, 'B', '2.5', 5),
(40, 'B', '4.0', 3),
(41, 'B', '6.5', 2),
(42, 'B', '10', 5),
(43, 'B', '15', 3),
(44, 'B', '25', 3),
(45, 'B', '40', 3),
(46, 'B', '65', 3),
(47, 'B', '100', 3),
(48, 'B', '150', 3),
(49, 'B', '250', 3),
(50, 'B', '400', 3),
(51, 'B', '650', 3),
(52, 'B', '1000', 3),
(53, 'C', '0.010', 1250),
(54, 'C', '0.015', 800),
(55, 'C', '0.025', 500),
(56, 'C', '0.040', 315),
(57, 'C', '0.065', 200),
(58, 'C', '0.10', 125),
(59, 'C', '0.15', 80),
(60, 'C', '0.25', 50),
(61, 'C', '0.40', 32),
(62, 'C', '0.65', 20),
(63, 'C', '1.0', 13),
(64, 'C', '1.5', 8),
(65, 'C', '2.5', 5),
(66, 'C', '4.0', 3),
(67, 'C', '6.5', 8),
(68, 'C', '10', 5),
(69, 'C', '15', 5),
(70, 'C', '25', 5),
(71, 'C', '40', 5),
(72, 'C', '65', 5),
(73, 'C', '100', 5),
(74, 'C', '150', 5),
(75, 'C', '250', 5),
(76, 'C', '400', 5),
(77, 'C', '650', 3),
(78, 'C', '1000', 3),
(79, 'D', '0.010', 1250),
(80, 'D', '0.015', 800),
(81, 'D', '0.025', 500),
(82, 'D', '0.040', 315),
(83, 'D', '0.065', 200),
(84, 'D', '0.10', 125),
(85, 'D', '0.15', 80),
(86, 'D', '0.25', 50),
(87, 'D', '0.40', 32),
(88, 'D', '0.65', 20),
(89, 'D', '1.0', 13),
(90, 'D', '1.5', 8),
(91, 'D', '2.5', 5),
(92, 'D', '4.0', 13),
(93, 'D', '6.5', 8),
(94, 'D', '10', 8),
(95, 'D', '15', 8),
(96, 'D', '25', 8),
(97, 'D', '40', 8),
(98, 'D', '65', 8),
(99, 'D', '100', 8),
(100, 'D', '150', 8),
(101, 'D', '250', 8),
(102, 'D', '400', 5),
(103, 'D', '650', 3),
(104, 'D', '1000', 3),
(105, 'E', '0.010', 1250),
(106, 'E', '0.015', 800),
(107, 'E', '0.025', 500),
(108, 'E', '0.040', 315),
(109, 'E', '0.065', 200),
(110, 'E', '0.10', 125),
(111, 'E', '0.15', 80),
(112, 'E', '0.25', 50),
(113, 'E', '0.40', 32),
(114, 'E', '0.65', 20),
(115, 'E', '1.0', 13),
(116, 'E', '1.5', 8),
(117, 'E', '2.5', 20),
(118, 'E', '4.0', 13),
(119, 'E', '6.5', 13),
(120, 'E', '10', 13),
(121, 'E', '15', 13),
(122, 'E', '25', 13),
(123, 'E', '40', 13),
(124, 'E', '65', 13),
(125, 'E', '100', 13),
(126, 'E', '150', 13),
(127, 'E', '250', 13),
(128, 'E', '400', 8),
(129, 'E', '650', 5),
(130, 'E', '1000', 3),
(131, 'F', '0.010', 1250),
(132, 'F', '0.015', 800),
(133, 'F', '0.025', 500),
(134, 'F', '0.040', 315),
(135, 'F', '0.065', 200),
(136, 'F', '0.10', 125),
(137, 'F', '0.15', 80),
(138, 'F', '0.25', 50),
(139, 'F', '0.40', 32),
(140, 'F', '0.65', 20),
(141, 'F', '1.0', 13),
(142, 'F', '1.5', 32),
(143, 'F', '2.5', 20),
(144, 'F', '4.0', 20),
(145, 'F', '6.5', 20),
(146, 'F', '10', 20),
(147, 'F', '15', 20),
(148, 'F', '25', 20),
(149, 'F', '40', 20),
(150, 'F', '65', 20),
(151, 'F', '100', 13),
(152, 'F', '150', 13),
(153, 'F', '250', 13),
(154, 'F', '400', 8),
(155, 'F', '650', 5),
(156, 'F', '1000', 3),
(157, 'G', '0.010', 1250),
(158, 'G', '0.015', 800),
(159, 'G', '0.025', 500),
(160, 'G', '0.040', 315),
(161, 'G', '0.065', 200),
(162, 'G', '0.10', 125),
(163, 'G', '0.15', 80),
(164, 'G', '0.25', 50),
(165, 'G', '0.40', 32),
(166, 'G', '0.65', 20),
(167, 'G', '1.0', 50),
(168, 'G', '1.5', 32),
(169, 'G', '2.5', 32),
(170, 'G', '4.0', 32),
(171, 'G', '6.5', 32),
(172, 'G', '10', 32),
(173, 'G', '15', 32),
(174, 'G', '25', 32),
(175, 'G', '40', 32),
(176, 'G', '65', 20),
(177, 'G', '100', 13),
(178, 'G', '150', 13),
(179, 'G', '250', 13),
(180, 'G', '400', 8),
(181, 'G', '650', 5),
(182, 'G', '1000', 3),
(183, 'H', '0.010', 1250),
(184, 'H', '0.015', 800),
(185, 'H', '0.025', 500),
(186, 'H', '0.040', 315),
(187, 'H', '0.065', 200),
(188, 'H', '0.10', 125),
(189, 'H', '0.15', 80),
(190, 'H', '0.25', 50),
(191, 'H', '0.40', 32),
(192, 'H', '0.65', 80),
(193, 'H', '1.0', 50),
(194, 'H', '1.5', 50),
(195, 'H', '2.5', 50),
(196, 'H', '4.0', 50),
(197, 'H', '6.5', 50),
(198, 'H', '10', 50),
(199, 'H', '15', 50),
(200, 'H', '25', 50),
(201, 'H', '40', 32),
(202, 'H', '65', 20),
(203, 'H', '100', 13),
(204, 'H', '150', 13),
(205, 'H', '250', 13),
(206, 'H', '400', 8),
(207, 'H', '650', 5),
(208, 'H', '1000', 3),
(209, 'J', '0.010', 1250),
(210, 'J', '0.015', 800),
(211, 'J', '0.025', 500),
(212, 'J', '0.040', 315),
(213, 'J', '0.065', 200),
(214, 'J', '0.10', 125),
(215, 'J', '0.15', 80),
(216, 'J', '0.25', 50),
(217, 'J', '0.40', 125),
(218, 'J', '0.65', 80),
(219, 'J', '1.0', 80),
(220, 'J', '1.5', 80),
(221, 'J', '2.5', 80),
(222, 'J', '4.0', 80),
(223, 'J', '6.5', 80),
(224, 'J', '10', 80),
(225, 'J', '15', 80),
(226, 'J', '25', 50),
(227, 'J', '40', 32),
(228, 'J', '65', 20),
(229, 'J', '100', 13),
(230, 'J', '150', 13),
(231, 'J', '250', 13),
(232, 'J', '400', 8),
(233, 'J', '650', 5),
(234, 'J', '1000', 3),
(235, 'K', '0.010', 1250),
(236, 'K', '0.015', 800),
(237, 'K', '0.025', 500),
(238, 'K', '0.040', 315),
(239, 'K', '0.065', 200),
(240, 'K', '0.10', 125),
(241, 'K', '0.15', 80),
(242, 'K', '0.25', 200),
(243, 'K', '0.40', 125),
(244, 'K', '0.65', 125),
(245, 'K', '1.0', 125),
(246, 'K', '1.5', 125),
(247, 'K', '2.5', 125),
(248, 'K', '4.0', 125),
(249, 'K', '6.5', 125),
(250, 'K', '10', 125),
(251, 'K', '15', 80),
(252, 'K', '25', 50),
(253, 'K', '40', 32),
(254, 'K', '65', 20),
(255, 'K', '100', 13),
(256, 'K', '150', 13),
(257, 'K', '250', 13),
(258, 'K', '400', 8),
(259, 'K', '650', 5),
(260, 'K', '1000', 3),
(261, 'L', '0.010', 1250),
(262, 'L', '0.015', 800),
(263, 'L', '0.025', 500),
(264, 'L', '0.040', 315),
(265, 'L', '0.065', 200),
(266, 'L', '0.10', 125),
(267, 'L', '0.15', 315),
(268, 'L', '0.25', 200),
(269, 'L', '0.40', 200),
(270, 'L', '0.65', 200),
(271, 'L', '1.0', 200),
(272, 'L', '1.5', 200),
(273, 'L', '2.5', 200),
(274, 'L', '4.0', 200),
(275, 'L', '6.5', 200),
(276, 'L', '10', 125),
(277, 'L', '15', 80),
(278, 'L', '25', 50),
(279, 'L', '40', 32),
(280, 'L', '65', 20),
(281, 'L', '100', 13),
(282, 'L', '150', 13),
(283, 'L', '250', 13),
(284, 'L', '400', 8),
(285, 'L', '650', 5),
(286, 'L', '1000', 3),
(287, 'M', '0.010', 1250),
(288, 'M', '0.015', 800),
(289, 'M', '0.025', 500),
(290, 'M', '0.040', 315),
(291, 'M', '0.065', 200),
(292, 'M', '0.10', 500),
(293, 'M', '0.15', 315),
(294, 'M', '0.25', 315),
(295, 'M', '0.40', 315),
(296, 'M', '0.65', 315),
(297, 'M', '1.0', 315),
(298, 'M', '1.5', 315),
(299, 'M', '2.5', 315),
(300, 'M', '4.0', 315),
(301, 'M', '6.5', 200),
(302, 'M', '10', 125),
(303, 'M', '15', 80),
(304, 'M', '25', 50),
(305, 'M', '40', 32),
(306, 'M', '65', 20),
(307, 'M', '100', 13),
(308, 'M', '150', 13),
(309, 'M', '250', 13),
(310, 'M', '400', 8),
(311, 'M', '650', 5),
(312, 'M', '1000', 3),
(313, 'N', '0.010', 1250),
(314, 'N', '0.015', 800),
(315, 'N', '0.025', 500),
(316, 'N', '0.040', 315),
(317, 'N', '0.065', 800),
(318, 'N', '0.10', 500),
(319, 'N', '0.15', 500),
(320, 'N', '0.25', 500),
(321, 'N', '0.40', 500),
(322, 'N', '0.65', 500),
(323, 'N', '1.0', 500),
(324, 'N', '1.5', 500),
(325, 'N', '2.5', 500),
(326, 'N', '4.0', 315),
(327, 'N', '6.5', 200),
(328, 'N', '10', 125),
(329, 'N', '15', 80),
(330, 'N', '25', 50),
(331, 'N', '40', 32),
(332, 'N', '65', 20),
(333, 'N', '100', 13),
(334, 'N', '150', 13),
(335, 'N', '250', 13),
(336, 'N', '400', 8),
(337, 'N', '650', 5),
(338, 'N', '1000', 3),
(339, 'P', '0.010', 1250),
(340, 'P', '0.015', 800),
(341, 'P', '0.025', 500),
(342, 'P', '0.040', 1250),
(343, 'P', '0.065', 800),
(344, 'P', '0.10', 800),
(345, 'P', '0.15', 800),
(346, 'P', '0.25', 800),
(347, 'P', '0.40', 800),
(348, 'P', '0.65', 800),
(349, 'P', '1.0', 800),
(350, 'P', '1.5', 800),
(351, 'P', '2.5', 500),
(352, 'P', '4.0', 315),
(353, 'P', '6.5', 200),
(354, 'P', '10', 125),
(355, 'P', '15', 80),
(356, 'P', '25', 50),
(357, 'P', '40', 32),
(358, 'P', '65', 20),
(359, 'P', '100', 13),
(360, 'P', '150', 13),
(361, 'P', '250', 13),
(362, 'P', '400', 8),
(363, 'P', '650', 5),
(364, 'P', '1000', 3),
(365, 'Q', '0.010', 1250),
(366, 'Q', '0.015', 800),
(367, 'Q', '0.025', 2000),
(368, 'Q', '0.040', 1250),
(369, 'Q', '0.065', 1250),
(370, 'Q', '0.10', 1250),
(371, 'Q', '0.15', 1250),
(372, 'Q', '0.25', 1250),
(373, 'Q', '0.40', 1250),
(374, 'Q', '0.65', 1250),
(375, 'Q', '1.0', 1250),
(376, 'Q', '1.5', 800),
(377, 'Q', '2.5', 500),
(378, 'Q', '4.0', 315),
(379, 'Q', '6.5', 200),
(380, 'Q', '10', 125),
(381, 'Q', '15', 80),
(382, 'Q', '25', 50),
(383, 'Q', '40', 32),
(384, 'Q', '65', 20),
(385, 'Q', '100', 13),
(386, 'Q', '150', 13),
(387, 'Q', '250', 13),
(388, 'Q', '400', 8),
(389, 'Q', '650', 5),
(390, 'Q', '1000', 3),
(391, 'R', '0.010', 1250),
(392, 'R', '0.015', 800),
(393, 'R', '0.025', 200),
(394, 'R', '0.040', 2000),
(395, 'R', '0.065', 2000),
(396, 'R', '0.10', 2000),
(397, 'R', '0.15', 2000),
(398, 'R', '0.25', 2000),
(399, 'R', '0.40', 2000),
(400, 'R', '0.65', 2000),
(401, 'R', '1.0', 1250),
(402, 'R', '1.5', 800),
(403, 'R', '2.5', 500),
(404, 'R', '4.0', 315),
(405, 'R', '6.5', 200),
(406, 'R', '10', 125),
(407, 'R', '15', 80),
(408, 'R', '25', 50),
(409, 'R', '40', 32),
(410, 'R', '65', 20),
(411, 'R', '100', 13),
(412, 'R', '150', 13),
(413, 'R', '250', 13),
(414, 'R', '400', 8),
(415, 'R', '650', 5),
(416, 'R', '1000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `auto_lot_code_mapping`
--

CREATE TABLE IF NOT EXISTS `auto_lot_code_mapping` (
`id` int(11) NOT NULL,
  `lower_val` mediumint(8) NOT NULL,
  `higher_val` mediumint(8) DEFAULT NULL,
  `inspection_level` varchar(10) NOT NULL,
  `code` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auto_lot_code_mapping`
--

INSERT INTO `auto_lot_code_mapping` (`id`, `lower_val`, `higher_val`, `inspection_level`, `code`) VALUES
(1, 2, 8, 'S-1', 'A'),
(2, 2, 8, 'S-2', 'A'),
(3, 2, 8, 'S-3', 'A'),
(4, 2, 8, 'S-4', 'A'),
(5, 2, 8, '1', 'A'),
(6, 2, 8, '2', 'A'),
(7, 2, 8, '3', 'B'),
(8, 9, 15, 'S-1', 'A'),
(9, 9, 15, 'S-2', 'A'),
(10, 9, 15, 'S-3', 'A'),
(11, 9, 15, 'S-4', 'A'),
(12, 9, 15, '1', 'A'),
(13, 9, 15, '2', 'B'),
(14, 9, 15, '3', 'C'),
(15, 16, 25, 'S-1', 'A'),
(16, 16, 25, 'S-2', 'A'),
(17, 16, 25, 'S-3', 'B'),
(18, 16, 25, 'S-4', 'B'),
(19, 16, 25, '1', 'B'),
(20, 16, 25, '2', 'C'),
(21, 16, 25, '3', 'D'),
(22, 26, 50, 'S-1', 'A'),
(23, 26, 50, 'S-2', 'B'),
(24, 26, 50, 'S-3', 'B'),
(25, 26, 50, 'S-4', 'C'),
(26, 26, 50, '1', 'C'),
(27, 26, 50, '2', 'D'),
(28, 26, 50, '3', 'E'),
(29, 51, 90, 'S-1', 'B'),
(30, 51, 90, 'S-2', 'B'),
(31, 51, 90, 'S-3', 'C'),
(32, 51, 90, 'S-4', 'C'),
(33, 51, 90, '1', 'C'),
(34, 51, 90, '2', 'E'),
(35, 51, 90, '3', 'F'),
(36, 91, 150, 'S-1', 'B'),
(37, 91, 150, 'S-2', 'B'),
(38, 91, 150, 'S-3', 'C'),
(39, 91, 150, 'S-4', 'D'),
(40, 91, 150, '1', 'D'),
(41, 91, 150, '2', 'F'),
(42, 91, 150, '3', 'G'),
(43, 151, 280, 'S-1', 'B'),
(44, 151, 280, 'S-2', 'C'),
(45, 151, 280, 'S-3', 'D'),
(46, 151, 280, 'S-4', 'E'),
(47, 151, 280, '1', 'E'),
(48, 151, 280, '2', 'G'),
(49, 151, 280, '3', 'H'),
(50, 281, 500, 'S-1', 'B'),
(51, 281, 500, 'S-2', 'C'),
(52, 281, 500, 'S-3', 'D'),
(53, 281, 500, 'S-4', 'E'),
(54, 281, 500, '1', 'F'),
(55, 281, 500, '2', 'H'),
(56, 281, 500, '3', 'J'),
(57, 501, 1200, 'S-1', 'C'),
(58, 501, 1200, 'S-2', 'C'),
(59, 501, 1200, 'S-3', 'E'),
(60, 501, 1200, 'S-4', 'F'),
(61, 501, 1200, '1', 'G'),
(62, 501, 1200, '2', 'J'),
(63, 501, 1200, '3', 'K'),
(64, 1201, 3200, 'S-1', 'C'),
(65, 1201, 3200, 'S-2', 'D'),
(66, 1201, 3200, 'S-3', 'E'),
(67, 1201, 3200, 'S-4', 'G'),
(68, 1201, 3200, '1', 'H'),
(69, 1201, 3200, '2', 'K'),
(70, 1201, 3200, '3', 'L'),
(71, 3201, 10000, 'S-1', 'C'),
(72, 3201, 10000, 'S-2', 'D'),
(73, 3201, 10000, 'S-3', 'F'),
(74, 3201, 10000, 'S-4', 'G'),
(75, 3201, 10000, '1', 'J'),
(76, 3201, 10000, '2', 'L'),
(77, 3201, 10000, '3', 'M'),
(78, 10001, 35000, 'S-1', 'C'),
(79, 10001, 35000, 'S-2', 'D'),
(80, 10001, 35000, 'S-3', 'F'),
(81, 10001, 35000, 'S-4', 'H'),
(82, 10001, 35000, '1', 'K'),
(83, 10001, 35000, '2', 'M'),
(84, 10001, 35000, '3', 'N'),
(85, 35001, 150000, 'S-1', 'D'),
(86, 35001, 150000, 'S-2', 'E'),
(87, 35001, 150000, 'S-3', 'G'),
(88, 35001, 150000, 'S-4', 'J'),
(89, 35001, 150000, '1', 'L'),
(90, 35001, 150000, '2', 'N'),
(91, 35001, 150000, '3', 'P'),
(92, 150001, 500000, 'S-1', 'D'),
(93, 150001, 500000, 'S-2', 'E'),
(94, 150001, 500000, 'S-3', 'G'),
(95, 150001, 500000, 'S-4', 'J'),
(96, 150001, 500000, '1', 'M'),
(97, 150001, 500000, '2', 'P'),
(98, 150001, 500000, '3', 'Q'),
(99, 500000, NULL, 'S-1', 'D'),
(100, 500000, NULL, 'S-2', 'E'),
(101, 500000, NULL, 'S-3', 'H'),
(102, 500000, NULL, 'S-4', 'k'),
(103, 500000, NULL, '1', 'N'),
(104, 500000, NULL, '2', 'Q'),
(105, 500000, NULL, '3', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `c=0`
--

CREATE TABLE IF NOT EXISTS `c=0` (
  `aql` decimal(3,2) DEFAULT NULL,
  `lower_val` int(6) DEFAULT NULL,
  `higher_val` varchar(6) DEFAULT NULL,
  `sample_qty` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `c=0`
--

INSERT INTO `c=0` (`aql`, `lower_val`, `higher_val`, `sample_qty`) VALUES
('0.65', 2, '8', 0),
('0.65', 9, '15', 0),
('0.65', 16, '25', 20),
('0.65', 26, '50', 20),
('0.65', 51, '90', 20),
('0.65', 91, '150', 20),
('0.65', 151, '280', 20),
('0.65', 281, '500', 47),
('0.65', 501, '1200', 47),
('0.65', 1201, '3200', 53),
('0.65', 3201, '10000', 68),
('0.65', 10001, '35000', 77),
('0.65', 35001, '150000', 96),
('0.65', 150001, '500000', 119),
('0.65', 500001, '', 143),
('1.50', 2, '8', 0),
('1.50', 9, '15', 8),
('1.50', 16, '25', 8),
('1.50', 26, '50', 8),
('1.50', 51, '90', 8),
('1.50', 91, '150', 12),
('1.50', 151, '280', 19),
('1.50', 281, '500', 21),
('1.50', 501, '1200', 27),
('1.50', 1201, '3200', 35),
('1.50', 3201, '10000', 38),
('1.50', 10001, '35000', 46),
('1.50', 35001, '150000', 56),
('1.50', 150001, '500000', 64),
('1.50', 500001, '', 64),
('2.50', 2, '8', 5),
('2.50', 9, '15', 5),
('2.50', 16, '25', 5),
('2.50', 26, '50', 5),
('2.50', 51, '90', 7),
('2.50', 91, '150', 11),
('2.50', 151, '280', 13),
('2.50', 281, '500', 16),
('2.50', 501, '1200', 19),
('2.50', 1201, '3200', 23),
('2.50', 3201, '10000', 29),
('2.50', 10001, '35000', 35),
('2.50', 35001, '150000', 40),
('2.50', 150001, '500000', 40),
('2.50', 500001, '', 40);

-- --------------------------------------------------------

--
-- Table structure for table `checklists`
--

CREATE TABLE IF NOT EXISTS `checklists` (
`id` int(11) NOT NULL,
  `item_no` smallint(4) NOT NULL,
  `list_item` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checklists`
--

INSERT INTO `checklists` (`id`, `item_no`, `list_item`, `product_id`, `created`, `modified`) VALUES
(1, 1, '12345', 1, '2016-12-21 12:10:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `checkpoints`
--

CREATE TABLE IF NOT EXISTS `checkpoints` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `checkpoint_no` smallint(4) NOT NULL,
  `insp_item` varchar(100) NOT NULL,
  `insp_item2` text CHARACTER SET utf8,
  `insp_item3` text CHARACTER SET utf8,
  `insp_item4` text,
  `spec` text CHARACTER SET utf8 NOT NULL,
  `has_multiple_specs` tinyint(1) NOT NULL,
  `lsl` varchar(10) DEFAULT NULL,
  `usl` varchar(10) DEFAULT NULL,
  `tgt` varchar(10) DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `checkpoint_type` enum('Supplier','LG') NOT NULL DEFAULT 'LG',
  `supplier_id` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checkpoints`
--

INSERT INTO `checkpoints` (`id`, `product_id`, `checkpoint_no`, `insp_item`, `insp_item2`, `insp_item3`, `insp_item4`, `spec`, `has_multiple_specs`, `lsl`, `usl`, `tgt`, `unit`, `checkpoint_type`, `supplier_id`, `approved_by`, `is_deleted`, `created`, `modified`) VALUES
(1, 1, 1, 'ABCD', '', '', NULL, 'ABCD ABCD', 0, '10', '20', '15', '5', 'LG', NULL, NULL, 0, '2016-12-20 09:30:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `checkpoint_history`
--

CREATE TABLE IF NOT EXISTS `checkpoint_history` (
`id` int(11) NOT NULL,
  `version` smallint(4) NOT NULL,
  `type` enum('Before','After') NOT NULL,
  `product_id` int(11) NOT NULL,
  `checkpoint_no` smallint(4) NOT NULL,
  `insp_item` varchar(100) NOT NULL,
  `insp_item2` text CHARACTER SET utf8,
  `insp_item3` text CHARACTER SET utf8 NOT NULL,
  `insp_item4` text,
  `spec` text CHARACTER SET utf8 NOT NULL,
  `lsl` varchar(10) DEFAULT NULL,
  `usl` varchar(10) DEFAULT NULL,
  `tgt` varchar(10) DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `checkpoint_type` enum('Supplier','LG') NOT NULL DEFAULT 'LG',
  `supplier_id` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `change_type` enum('Added','Deleted','Updated') NOT NULL,
  `changed_on` datetime NOT NULL,
  `remark` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checkpoint_history`
--

INSERT INTO `checkpoint_history` (`id`, `version`, `type`, `product_id`, `checkpoint_no`, `insp_item`, `insp_item2`, `insp_item3`, `insp_item4`, `spec`, `lsl`, `usl`, `tgt`, `unit`, `checkpoint_type`, `supplier_id`, `approved_by`, `change_type`, `changed_on`, `remark`, `created`) VALUES
(1, 1, 'After', 1, 1, 'ABCD', '', '', NULL, 'ABCD ABCD', '10', '20', '15', '5', 'LG', NULL, NULL, 'Added', '2016-12-20 09:30:03', '', '2016-12-20 09:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `checkpoint_specs`
--

CREATE TABLE IF NOT EXISTS `checkpoint_specs` (
`id` int(11) NOT NULL,
  `checkpoint_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `lsl` varchar(10) NOT NULL,
  `usl` varchar(10) NOT NULL,
  `tgt` varchar(10) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `excluded_checkpoints`
--

CREATE TABLE IF NOT EXISTS `excluded_checkpoints` (
`id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `checkpoints_ids` text NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inspection_config`
--

INSERT INTO `inspection_config` (`id`, `product_id`, `checkpoint_id`, `part_id`, `sampling_type`, `inspection_level`, `acceptable_quality`, `aql`, `lot_qty`, `no_of_months`, `no_of_times`, `created`, `modified`) VALUES
(3, 1, 1, 1, 'C=0', NULL, NULL, '1.5', '10', NULL, NULL, '2016-12-21 20:14:33', '2016-12-21 20:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_lot_range`
--

CREATE TABLE IF NOT EXISTS `inspection_lot_range` (
`id` int(11) NOT NULL,
  `config_id` int(11) NOT NULL,
  `lower_val` mediumint(8) NOT NULL,
  `higher_val` mediumint(8) DEFAULT NULL,
  `no_of_samples` mediumint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lot_template`
--

CREATE TABLE IF NOT EXISTS `lot_template` (
`id` int(11) NOT NULL,
  `lower_val` mediumint(8) NOT NULL,
  `higher_val` mediumint(8) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lot_template`
--

INSERT INTO `lot_template` (`id`, `lower_val`, `higher_val`) VALUES
(1, 2, 8),
(2, 9, 15),
(3, 16, 25),
(4, 26, 50),
(5, 51, 90),
(6, 91, 150),
(7, 151, 280),
(8, 281, 500),
(9, 501, 1200),
(10, 1201, 3200),
(16, 3201, 10000),
(17, 10001, 35000),
(18, 35001, 150000),
(19, 150001, 500000),
(20, 500000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers`
--

CREATE TABLE IF NOT EXISTS `phone_numbers` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `phone_numbers`
--

INSERT INTO `phone_numbers` (`id`, `supplier_id`, `name`, `phone_number`, `created`, `modified`) VALUES
(1, 4, 'Sup', '911234567897', '2016-12-21 11:28:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL,
  `org_id` varchar(20) NOT NULL,
  `org_name` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `org_id`, `org_name`, `code`, `name`, `created`, `modified`) VALUES
(1, '', 'AP4', 'TV', 'Television', '2016-12-04 18:28:05', '2016-12-04 18:50:11'),
(2, '195373', 'AP2', 'REF', 'Refrigerator', '2016-12-04 18:56:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_parts`
--

CREATE TABLE IF NOT EXISTS `product_parts` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_parts`
--

INSERT INTO `product_parts` (`id`, `product_id`, `code`, `name`, `is_deleted`, `created`, `modified`) VALUES
(1, 1, 'P01', 'Part 1', 0, '2016-12-21 09:46:53', NULL),
(2, 1, 'P02', 'Part 2', 0, '2016-12-21 09:55:59', NULL),
(3, 1, 'P03', 'Part 3', 0, '2016-12-21 09:55:59', NULL),
(4, 1, 'P04', 'Part 4', 0, '2016-12-21 09:55:59', NULL),
(5, 1, 'P05', 'Part 5', 0, '2016-12-21 09:55:59', NULL),
(6, 1, 'P06', 'Part 6', 0, '2016-12-21 09:55:59', NULL),
(7, 1, 'P07', 'Part 7', 0, '2016-12-21 09:55:59', NULL),
(8, 1, 'P08', 'Part 8', 0, '2016-12-21 09:55:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sp_mappings`
--

CREATE TABLE IF NOT EXISTS `sp_mappings` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sp_mappings`
--

INSERT INTO `sp_mappings` (`id`, `supplier_id`, `product_id`, `part_id`, `created`, `modified`) VALUES
(1, 4, 1, 1, '2016-12-21 11:18:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
`id` int(11) NOT NULL,
  `supplier_no` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `checklist_checked` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_no`, `name`, `email`, `password`, `is_active`, `checklist_checked`, `created`, `modified`) VALUES
(4, '1', 'Supplier 1', 'sup@gmail.com', '$2y$10$.jG6bJU1u7NGrWbftP1Nreo/LhRaakBoy7yI6Xn8Qgsty.O6JwhFy', 1, '0000-00-00', '2016-12-08 02:26:00', '2016-12-21 14:23:20'),
(5, 'IN029235', 'Uttam Galva', 'abc@gmail.com', '$2y$10$uoHPX6fxKL7n9kXfkLxRoeFglwi5e8DNWDzSsTWcMS.HHSoCz/Wq2', 1, '0000-00-00', '2016-12-16 02:04:24', NULL),
(6, 'KR050794', 'Heasung Electronics', 'xyz@gmail.com', '$2y$10$uoHPX6fxKL7n9kXfkLxRoeFglwi5e8DNWDzSsTWcMS.HHSoCz/Wq2', 1, '0000-00-00', '2016-12-16 02:04:24', NULL),
(7, 'SUP001122', 'Sup New', 'sup_new@gmail.com', '$2y$10$1xQQgAq1Tcv8WJc.DxS8le4vdLgcFlLieuMNUq/.SJOrrqb0TAZJm', 1, '0000-00-00', '2016-12-21 12:18:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_inspector`
--

CREATE TABLE IF NOT EXISTS `supplier_inspector` (
`id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `checklist_checked` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier_inspector`
--

INSERT INTO `supplier_inspector` (`id`, `supplier_id`, `name`, `email`, `password`, `is_active`, `checklist_checked`, `created`, `modified`) VALUES
(1, 4, 'Inspector 1', 'insp@gmail.com', '$2y$10$.jG6bJU1u7NGrWbftP1Nreo/LhRaakBoy7yI6Xn8Qgsty.O6JwhFy', 1, '2016-12-22', '2016-12-21 16:06:01', '2016-12-22 11:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_type` enum('Admin','LG Inspector') NOT NULL,
  `reset_token` varchar(50) DEFAULT NULL,
  `reset_request_time` datetime DEFAULT NULL,
  `checklist_checked` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `product_id`, `first_name`, `last_name`, `username`, `email`, `password`, `is_active`, `user_type`, `reset_token`, `reset_request_time`, `checklist_checked`, `created`, `modified`) VALUES
(2, NULL, 'Super', 'Admin', 'suadmin', '', '$2y$10$.jG6bJU1u7NGrWbftP1Nreo/LhRaakBoy7yI6Xn8Qgsty.O6JwhFy', 1, 'Admin', NULL, NULL, '0000-00-00', '2014-09-28 10:09:06', '2015-04-14 21:56:02'),
(77, '1,2', 'Nikhil', 'Monga', 'nikhilm', 'nikhilmonga2002@gmail.com', '$2y$10$.jG6bJU1u7NGrWbftP1Nreo/LhRaakBoy7yI6Xn8Qgsty.O6JwhFy', 1, 'Admin', NULL, NULL, '0000-00-00', '2016-12-04 18:57:07', NULL),
(78, '1', 'Nikhil', 'Monga', 'nikhil.inspector', 'er.nikhilmonga@gmail.com', '$2y$10$.jG6bJU1u7NGrWbftP1Nreo/LhRaakBoy7yI6Xn8Qgsty.O6JwhFy', 1, 'LG Inspector', NULL, NULL, '0000-00-00', '2016-12-04 19:10:51', '2016-12-04 19:12:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
 ADD PRIMARY KEY (`id`), ADD KEY `audit_date` (`audit_date`,`product_id`);

--
-- Indexes for table `audit_checkpoints`
--
ALTER TABLE `audit_checkpoints`
 ADD PRIMARY KEY (`id`), ADD KEY `audit_id` (`audit_id`,`checkpoint_no`);

--
-- Indexes for table `auto_code_acceptance_sample_mapping`
--
ALTER TABLE `auto_code_acceptance_sample_mapping`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auto_lot_code_mapping`
--
ALTER TABLE `auto_lot_code_mapping`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checklists`
--
ALTER TABLE `checklists`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkpoints`
--
ALTER TABLE `checkpoints`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkpoint_history`
--
ALTER TABLE `checkpoint_history`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkpoint_specs`
--
ALTER TABLE `checkpoint_specs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excluded_checkpoints`
--
ALTER TABLE `excluded_checkpoints`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspection_config`
--
ALTER TABLE `inspection_config`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspection_lot_range`
--
ALTER TABLE `inspection_lot_range`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lot_template`
--
ALTER TABLE `lot_template`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_parts`
--
ALTER TABLE `product_parts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_mappings`
--
ALTER TABLE `sp_mappings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_inspector`
--
ALTER TABLE `supplier_inspector`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `audit_checkpoints`
--
ALTER TABLE `audit_checkpoints`
MODIFY `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `auto_code_acceptance_sample_mapping`
--
ALTER TABLE `auto_code_acceptance_sample_mapping`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=417;
--
-- AUTO_INCREMENT for table `auto_lot_code_mapping`
--
ALTER TABLE `auto_lot_code_mapping`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT for table `checklists`
--
ALTER TABLE `checklists`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `checkpoints`
--
ALTER TABLE `checkpoints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `checkpoint_history`
--
ALTER TABLE `checkpoint_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `checkpoint_specs`
--
ALTER TABLE `checkpoint_specs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `excluded_checkpoints`
--
ALTER TABLE `excluded_checkpoints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inspection_config`
--
ALTER TABLE `inspection_config`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `inspection_lot_range`
--
ALTER TABLE `inspection_lot_range`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lot_template`
--
ALTER TABLE `lot_template`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `product_parts`
--
ALTER TABLE `product_parts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sp_mappings`
--
ALTER TABLE `sp_mappings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `supplier_inspector`
--
ALTER TABLE `supplier_inspector`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
