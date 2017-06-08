--
-- Table structure for table `tc_checkpoints`
--

CREATE TABLE IF NOT EXISTS `tc_checkpoints` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `checkpoint_no` smallint(4) DEFAULT NULL,
  `insp_type` varchar(100) NOT NULL,
  `insp_item` text CHARACTER SET utf8,
  `spec` text CHARACTER SET utf8 NOT NULL,
  `lsl` varchar(10) DEFAULT NULL,
  `usl` varchar(10) DEFAULT NULL,
  `tgt` varchar(10) DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `sample_qty` varchar(10) NOT NULL,
  `frequency` varchar(10) NOT NULL,
  `measure_type` varchar(50) NOT NULL,
  `instrument` varchar(100) NOT NULL,
  `action_by` varchar(25) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3054 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tc_checkpoints`
--
ALTER TABLE `tc_checkpoints`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tc_checkpoints`
--
ALTER TABLE `tc_checkpoints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `timechecks`
--

CREATE TABLE IF NOT EXISTS `timechecks` (
`id` int(11) NOT NULL,
  `org_checkpoint_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `checkpoint_no` smallint(4) DEFAULT NULL,
  `insp_type` varchar(100) NOT NULL,
  `insp_item` text CHARACTER SET utf8,
  `spec` text CHARACTER SET utf8 NOT NULL,
  `lsl` varchar(10) DEFAULT NULL,
  `usl` varchar(10) DEFAULT NULL,
  `tgt` varchar(10) DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `sample_qty` varchar(10) NOT NULL,
  `frequency` varchar(10) NOT NULL,
  `measure_type` varchar(50) NOT NULL,
  `instrument` varchar(100) NOT NULL,
  `all_values` text,
  `all_results` text,
  `result` enum('OK','NG') DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timechecks`
--
ALTER TABLE `timechecks`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `timechecks`
--
ALTER TABLE `timechecks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `timecheck_plans`
--

CREATE TABLE IF NOT EXISTS `timecheck_plans` (
`id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `plan_date` date NOT NULL,
  `from_time` varchar(20) NOT NULL,
  `to_time` varchar(20) NOT NULL,
  `plan_status` enum('Started','Completed') DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timecheck_plans`
--
ALTER TABLE `timecheck_plans`
 ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `timecheck_plans`
--
ALTER TABLE `timecheck_plans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;