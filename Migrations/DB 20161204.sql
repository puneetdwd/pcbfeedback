--
-- Database: `sqim`
--

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
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `product_id`, `first_name`, `last_name`, `username`, `email`, `password`, `is_active`, `user_type`, `reset_token`, `reset_request_time`, `created`, `modified`) VALUES
(2, NULL, 'Super', 'Admin', 'suadmin', '', '$2y$10$czc/47dl1qaFWh8p974rLeZyr2zL1G5Hhd3JZY2vxhpLXB.45RQ8W', 1, 'Admin', NULL, NULL, '2014-09-28 10:09:06', '2015-04-14 21:56:02'),
(77, '1,2', 'Nikhil', 'Monga', 'nikhilm', 'nikhilmonga2002@gmail.com', '$2y$10$zUUTOv9jAkldMkq1DN5p4ucpcrf8yg5TGHi1OEbnmScSAW/Olh5b6', 1, 'Admin', NULL, NULL, '2016-12-04 18:57:07', NULL),
(78, '1', 'Nikhil', 'Monga', 'nikhil.inspector', 'er.nikhilmonga@gmail.com', '$2y$10$h2APhCeUXFArek/s7TbF9uTsc976wCn5xCFK3aDay73J6Rs6..Cb2', 1, 'LG Inspector', NULL, NULL, '2016-12-04 19:10:51', '2016-12-04 19:12:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
