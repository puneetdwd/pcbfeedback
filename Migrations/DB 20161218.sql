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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;