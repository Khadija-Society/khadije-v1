CREATE TABLE `s_group` (
`id`         int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`title`      varchar(500) CHARACTER SET utf8mb4 NULL,
`type`       enum('blacklist','family','bank','other', 'auto') NULL DEFAULT NULL,
`status`     enum('enable', 'deleted', 'disable') NULL DEFAULT 'enable',
`analyze`    bit(1) NULL DEFAULT NULL,
`ismoney`    bit(1) NULL DEFAULT NULL,
`count`    int(10) UNSIGNED NULL DEFAULT NULL,
`answer`     mediumtext CHARACTER SET utf8mb4,
`creator`     int(10) UNSIGNED NOT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `s_group_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `s_groupfilter` (
`id`         int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`type`       enum('number','answer','analyze','other') NULL DEFAULT NULL,
`number`      varchar(100) CHARACTER SET utf8mb4 NULL,
`group_id`     int(10) UNSIGNED NOT NULL,
`text`      varchar(100) CHARACTER SET utf8mb4 NULL,
`exactly`    bit(1) NULL DEFAULT NULL,
`contain`    bit(1) NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `s_group_group_id` FOREIGN KEY (`group_id`) REFERENCES `s_group` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `s_sms` (
`id`          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`fromnumber` varchar(100) CHARACTER SET utf8mb4  NULL DEFAULT NULL,
`togateway` varchar(100) CHARACTER SET utf8mb4  NULL DEFAULT NULL,
`fromgateway` varchar(100) CHARACTER SET utf8mb4  NULL DEFAULT NULL,
`text`       text CHARACTER SET utf8mb4,
`tonumber` varchar(100) CHARACTER SET utf8mb4  NULL DEFAULT NULL,
`user_id`     int(10) UNSIGNED NULL,
`date` datetime NULL DEFAULT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`uniquecode` varchar(100) NULL DEFAULT NULL,
`reseivestatus` enum('block', 'awaiting', 'analyze', 'answerready') NULL DEFAULT NULL,
`sendstatus` enum('awaiting', 'sendtodevice', 'send', 'deliver') NULL DEFAULT NULL,
`amount` int(10) UNSIGNED NULL DEFAULT NULL,
`answertext`       text CHARACTER SET utf8mb4,
`group_id` int(10) UNSIGNED NULL DEFAULT NULL,
`recomand_id` int(10) UNSIGNED NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `s_sms_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `s_sms_smsgroup_id` FOREIGN KEY (`group_id`) REFERENCES `s_group` (`id`) ON UPDATE CASCADE,
CONSTRAINT `s_sms_smsrecomand_id` FOREIGN KEY (`recomand_id`) REFERENCES `s_group` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
