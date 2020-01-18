ALTER TABLE `users` CHANGE `married` `married` ENUM('single','married','leave','dead') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` ADD `child` int(10)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shcode` int(10)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shfrom` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `birthcity` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `bank` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `hesab` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shaba` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `card` varchar(200)  NULL DEFAULT NULL;


-- khadem
CREATE TABLE `agent_servant` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant') NULL,
`city` enum('qom', 'mashhad', 'karbala') NULL,
`status` enum('enable', 'disable') NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_servant_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- takhasos
CREATE TABLE `agent_skills` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(100)  NOT NULL,
`status` enum('enable', 'disable', 'deleted') NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `agent_userskills` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`skills_id` int(10) UNSIGNED  NOT NULL,
`user_id` int(10) UNSIGNED  NOT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_userskills_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_userskills_skills_id` FOREIGN KEY (`skills_id`) REFERENCES `agent_skills` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `agent_resume` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`creator` int(10) UNSIGNED  NULL DEFAULT NULL,
`company` varchar(100) NULL DEFAULT NULL,
`type` varchar(100) NULL DEFAULT NULL,
`startdate` varchar(50) NULL DEFAULT NULL,
`enddate` varchar(50) NULL DEFAULT NULL,
`ceo` varchar(100) NULL DEFAULT NULL,
`desc` text   NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_resume_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_resume_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- place
CREATE TABLE `agent_place` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`subtitle` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`file` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`capacity` int(10) UNSIGNED NULL DEFAULT NULL,
`gender` enum('male', 'female', 'all') NULL DEFAULT NULL,
`city` enum('qom', 'mashhad', 'karbala', 'other') NULL DEFAULT NULL,
`sort` int(10) UNSIGNED NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

