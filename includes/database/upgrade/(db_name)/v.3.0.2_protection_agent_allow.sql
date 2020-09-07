

CREATE TABLE `protection_agent_occasion_allow` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int(10) UNSIGNED NOT NULL,
`protection_agent_id` int(10) UNSIGNED NOT NULL,
`datenotif` datetime  NULL DEFAULT NULL,
`datemodified` datetime  NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_agent_occasion_allow_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_agent_occasion_allow_agent_id` FOREIGN KEY (`protection_agent_id`) REFERENCES `protection_agent` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

