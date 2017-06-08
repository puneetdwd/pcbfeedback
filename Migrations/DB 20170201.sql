ALTER TABLE `timechecks` ADD `stage` VARCHAR(100) NOT NULL AFTER `supplier_id`;
ALTER TABLE `tc_checkpoints` ADD `stage` VARCHAR(100) NOT NULL AFTER `supplier_id`;