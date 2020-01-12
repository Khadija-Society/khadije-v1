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
CREATE TABLE `servant` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`job` enum('rohani', 'admin', 'missionary', 'servant') NULL,
`city` enum('qom', 'mashhad', 'karbala') NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `servant_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- takhasos
CREATE TABLE `specialty` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(100)  NOT NULL,
`status` enum('enable', 'disable', 'deleted') NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `userspecialty` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`specialty_id` int(10) UNSIGNED  NOT NULL,
`user_id` int(10) UNSIGNED  NOT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `userspecialty_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `userspecialty_specialty_id` FOREIGN KEY (`specialty_id`) REFERENCES `specialty` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `workhistory` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`creator` int(10) UNSIGNED  NULL DEFAULT NULL,
`organ` varchar(100)   NULL DEFAULT NULL,
`type` varchar(100)   NULL DEFAULT NULL,
`startdate` datetime  NULL DEFAULT NULL,
`enddate` datetime  NULL DEFAULT NULL,
`admin` varchar(100)   NULL DEFAULT NULL,
`desc` text   NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `workhistory_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `workhistory_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- place
CREATE TABLE `dispatchplace` (
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



-- ezam
CREATE TABLE `dispatch` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NOT NULL,
`creator` int(10) UNSIGNED  NULL DEFAULT NULL,
`dispatchplace_id` int(10) UNSIGNED  NULL DEFAULT NULL,
`job` enum('rohani', 'admin', 'missionary', 'servant') NULL,
`city` enum('qom', 'mashhad', 'karbala') NULL,
`startdate` datetime  NULL DEFAULT NULL,
`enddate` datetime  NULL DEFAULT NULL,
`payamount` int(10) NULL DEFAULT NULL,
`paybank` varchar(100)   NULL DEFAULT NULL,
`paytype` varchar(100)   NULL DEFAULT NULL,
`payvalue` varchar(100)   NULL DEFAULT NULL,
`gift` text   NULL DEFAULT NULL,
`desc` text   NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `dispatch_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `dispatch_dispatchplace_id` FOREIGN KEY (`dispatchplace_id`) REFERENCES `dispatchplace` (`id`) ON UPDATE CASCADE,
CONSTRAINT `dispatch_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- item feedback
CREATE TABLE `assessmentitem` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`rate` int(10) NULL DEFAULT NULL,
`job` enum('rohani', 'admin', 'missionary', 'servant') NULL,
`city` enum('qom', 'mashhad', 'karbala') NULL,
`sort` int(10) UNSIGNED NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- feedback
CREATE TABLE `assessment` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`dispatch_id` int(10) UNSIGNED NOT NULL,
`assessmentor` int(10) UNSIGNED  NULL DEFAULT NULL,
`avgrate` int(10) NULL DEFAULT NULL,
`desc` text   NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `assessment_dispatchplace_id` FOREIGN KEY (`dispatch_id`) REFERENCES `dispatch` (`id`) ON UPDATE CASCADE,
CONSTRAINT `assessment_assessmentor` FOREIGN KEY (`assessmentor`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- feedback detail
CREATE TABLE `assessmentdetail` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`assessment_id` int(10) UNSIGNED NOT NULL,
`assessmentitem_id` int(10) UNSIGNED NOT NULL,
`star` int(10) UNSIGNED  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `assessmentdetail_assessment_id` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`id`) ON UPDATE CASCADE,
CONSTRAINT `assessmentdetail_assessmentitem_id` FOREIGN KEY (`assessmentitem_id`) REFERENCES `assessmentitem` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

