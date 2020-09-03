CREATE TABLE `protection_type` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(300) NULL DEFAULT NULL,
`status` enum('enable', 'deleted') NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `protection_occasion_type` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int(10) UNSIGNED NOT NULL,
`type_id` int(10) UNSIGNED NOT NULL,
`percent` int(10) NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8mb4,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_occasion_type_occation_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_occasion_type_type_id` FOREIGN KEY (`type_id`) REFERENCES `protection_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




ALTER TABLE `protection_user_agent_occasion` ADD `type_id` int(10) UNSIGNED NULL;
ALTER TABLE `protection_user_agent_occasion` ADD CONSTRAINT `protection_user_agent_type_id` FOREIGN KEY (`type_id`) REFERENCES `protection_type` (`id`) ON UPDATE CASCADE;
