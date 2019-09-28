CREATE TABLE `place` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`subtitle` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`activetime` int(10) NULL DEFAULT NULL,
`cleantime` time NULL DEFAULT NULL,
`address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`file` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`capacity` int(10) UNSIGNED NULL DEFAULT NULL,
`city` enum('qom', 'mashhad', 'karbala', 'other') NULL DEFAULT NULL,
`sort` int(10) UNSIGNED NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted', 'publish')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

