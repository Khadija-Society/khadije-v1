CREATE TABLE `protection_agent_occasion_child` (
`id` int UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int UNSIGNED NOT NULL,
`protection_agent_id` int UNSIGNED NOT NULL,
`user_id` int UNSIGNED NOT NULL,
`capacity` int  NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted') NULL DEFAULT NULL,
`displayname` varchar(200)  NULL DEFAULT NULL,
`desc` text  NULL DEFAULT NULL,
`datemodified` datetime  NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_agent_occasion_child_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_agent_occasion_child_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_agent_occasion_child_agent_id` FOREIGN KEY (`protection_agent_id`) REFERENCES `protection_agent` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `protection_user_agent_occasion` ADD `creator` int UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `protection_user_agent_occasion` ADD CONSTRAINT `protection_user_agent_occasion_creator` FOREIGN KEY (`creator`) REFERENCES `protection_agent_occasion_child` (`id`) ON UPDATE CASCADE;