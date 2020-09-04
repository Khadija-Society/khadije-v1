ALTER TABLE `protection_user_agent_occasion` ADD `admindesc` text CHARACTER SET utf8mb4;
ALTER TABLE `protection_user_agent_occasion` ADD `gender` enum('male', 'female') NULL;
ALTER TABLE `protection_user_agent_occasion` ADD `married` enum('single', 'married') NULL;
ALTER TABLE `protection_user_agent_occasion` ADD `birthday` date NULL DEFAULT NULL;

ALTER TABLE `protection_user_agent_occasion` ADD `type_id` int(10) unsigned NULL DEFAULT NULL;
ALTER TABLE `protection_user_agent_occasion` ADD CONSTRAINT `protection_user_agent_type_id` FOREIGN KEY (`type_id`) REFERENCES `protection_type` (`id`) ON UPDATE CASCADE;



ALTER TABLE `protection_agent_occasion` ADD `bankaccountnumber` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `protection_agent_occasion` ADD `bankshaba` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `protection_agent_occasion` ADD `bankhesab` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `protection_agent_occasion` ADD `bankcart` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `protection_agent_occasion` ADD `bankname` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `protection_agent_occasion` ADD `bankownername` varchar(200) NULL DEFAULT NULL;