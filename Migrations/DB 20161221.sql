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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `excluded_checkpoints`
--
ALTER TABLE `excluded_checkpoints`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `excluded_checkpoints`
--
ALTER TABLE `excluded_checkpoints`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;


ALTER TABLE `checkpoints` ADD `supplier_id` INT(11) NULL DEFAULT NULL AFTER `unit`;
ALTER TABLE `checkpoints` ADD `checkpoint_type` ENUM('Supplier','LG') NOT NULL DEFAULT 'LG' AFTER `unit`;
ALTER TABLE `checkpoints` ADD `approved_by` INT(11) NULL DEFAULT NULL AFTER `supplier_id`;

ALTER TABLE `checkpoint_history` ADD `supplier_id` INT(11) NULL DEFAULT NULL AFTER `unit`;
ALTER TABLE `checkpoint_history` ADD `checkpoint_type` ENUM('Supplier','LG') NOT NULL DEFAULT 'LG' AFTER `unit`;
ALTER TABLE `checkpoint_history` ADD `approved_by` INT(11) NULL DEFAULT NULL AFTER `supplier_id`;

--
-- Database: `sqim`
--

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
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `supplier_inspector`
--
ALTER TABLE `supplier_inspector`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supplier_inspector`
--
ALTER TABLE `supplier_inspector`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


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
) ENGINE=InnoDB AUTO_INCREMENT=864 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inspection_lot_range`
--
ALTER TABLE `inspection_lot_range`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inspection_lot_range`
--
ALTER TABLE `inspection_lot_range`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=864;
