ALTER TABLE `suppliers` CHANGE `is_user` `is_active` TINYINT(1) NOT NULL DEFAULT '1'; 
ALTER TABLE `suppliers` ADD `user_type` VARCHAR(25) NOT NULL AFTER `is_active`;