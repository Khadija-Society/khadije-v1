CREATE TABLE `lottery` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`table` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`date` datetime  NULL DEFAULT NULL,
`countall` int(10) NULL DEFAULT NULL,
`countperlevel` int(10) NULL DEFAULT NULL,
`countlevel` int(10) NULL DEFAULT NULL,
`win` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted', 'publish')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `karbala2users` ADD `lottery_id` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `karbala2users` ADD CONSTRAINT `karbala2users_lottery_id` FOREIGN KEY (`lottery_id`) REFERENCES `lottery` (`id`) ON UPDATE CASCADE;