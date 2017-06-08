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
  `is_deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkpoints`
--
ALTER TABLE `checkpoints`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkpoints`
--
ALTER TABLE `checkpoints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  `change_type` enum('Added','Deleted','Updated') NOT NULL,
  `changed_on` datetime NOT NULL,
  `remark` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkpoint_history`
--
ALTER TABLE `checkpoint_history`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkpoint_history`
--
ALTER TABLE `checkpoint_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;