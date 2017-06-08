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
-- Indexes for dumped tables
--

--
-- Indexes for table `checklists`
--
ALTER TABLE `checklists`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklists`
--
ALTER TABLE `checklists`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;