CREATE TABLE `protection_agent` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`title` varchar(300) NULL DEFAULT NULL,
`type` varchar(200) NULL DEFAULT NULL,
`status` enum('draft', 'pending', 'enable', 'block', 'deleted') NULL,
`desc` text CHARACTER SET utf8mb4,
`bankaccountnumber` varchar(200) NULL DEFAULT NULL,
`bankshaba` varchar(200) NULL DEFAULT NULL,
`bankhesab` varchar(200) NULL DEFAULT NULL,
`bankcart` varchar(200) NULL DEFAULT NULL,
`bankname` varchar(200) NULL DEFAULT NULL,
`bankownername` varchar(200) NULL DEFAULT NULL,
`province` varchar(100) NULL DEFAULT NULL,
`city` varchar(100) NULL DEFAULT NULL,
`address` text NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
`datemodified` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_agent_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `protection_user` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NULL,
`mobile` varchar(15)  NULL,
`displayname` varchar(100) NULL,
`nationalcode` varchar(50) NULL,
`status` enum('pending', 'enable', 'block', 'deleted') NULL,
`province` varchar(50) NULL DEFAULT NULL,
`city` varchar(50) NULL DEFAULT NULL,
`postalcode` varchar(50) NULL DEFAULT NULL,
`address` text NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8mb4,
`protectioncount` smallint(5) NULL,
`type` varchar(200) NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
`datemodified` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `protection_occasion` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) NULL,
`subtitle` varchar(200) NULL,
`startdate` datetime NULL,
`expiredate` datetime NULL,
`type` varchar(200) NULL DEFAULT NULL,
`status` enum('draft', 'registring', 'done', 'distribution', 'deleted') NULL,
`desc` text CHARACTER SET utf8mb4,
`datecreated` datetime  NULL DEFAULT NULL,
`datemodified` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `protection_occasion_detail` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int(10) UNSIGNED NOT NULL,
`title` varchar(200) NULL,
`price` bigint(20) NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8mb4,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_occasion_detail_occation_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE `protection_user_agent_occasion` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int(10) UNSIGNED NOT NULL,
`protection_user_id` int(10) UNSIGNED NOT NULL,
`protection_agent_id` int(10) UNSIGNED NOT NULL,
`status` enum('request', 'accept', 'reject') NULL,
`desc` text CHARACTER SET utf8mb4,
`datemodified` datetime  NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_user_agent_occasion_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_user_agent_occasion_user_id` FOREIGN KEY (`protection_user_id`) REFERENCES `protection_user` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_user_agent_occasion_agent_id` FOREIGN KEY (`protection_agent_id`) REFERENCES `protection_agent` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




CREATE TABLE `protection_agent_occasion` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`protection_occasion_id` int(10) UNSIGNED NOT NULL,
`protection_agent_id` int(10) UNSIGNED NOT NULL,
`status` enum('request', 'accept', 'reject') NULL,
`trackingnumber` varchar(200) NULL,
`total_price` bigint(20)  NULL,
`paydate` datetime NULL,
`desc` text CHARACTER SET utf8mb4,
`report` text CHARACTER SET utf8mb4,
`gallery` text CHARACTER SET utf8mb4,
`datemodified` datetime  NULL DEFAULT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `protection_agent_occasion_id` FOREIGN KEY (`protection_occasion_id`) REFERENCES `protection_occasion` (`id`) ON UPDATE CASCADE,
CONSTRAINT `protection_agent_occasion_agent_id` FOREIGN KEY (`protection_agent_id`) REFERENCES `protection_agent` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

