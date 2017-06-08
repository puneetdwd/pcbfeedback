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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
 ADD PRIMARY KEY (`id`), ADD KEY `audit_date` (`audit_date`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_checkpoints`
--
ALTER TABLE `audit_checkpoints`
 ADD PRIMARY KEY (`id`), ADD KEY `audit_id` (`audit_id`,`checkpoint_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_checkpoints`
--
ALTER TABLE `audit_checkpoints`
MODIFY `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkpoint_specs`
--
ALTER TABLE `checkpoint_specs`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkpoint_specs`
--
ALTER TABLE `checkpoint_specs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;