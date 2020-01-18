

-- ezam
CREATE TABLE `agent_send` (
`id` int(10) UNSIGNED NOT NULL auto_increment,

`creator` int(10) UNSIGNED  NULL DEFAULT NULL,

`clergy_id` int(10) UNSIGNED  NULL,
`admin_id` int(10) UNSIGNED  NULL,
`adminoffice_id` int(10) UNSIGNED  NULL,
`missionary_id` int(10) UNSIGNED  NULL,
`servant_id` int(10) UNSIGNED  NULL,

`place_id` int(10) UNSIGNED  NULL DEFAULT NULL,

`city` enum('qom', 'mashhad', 'karbala') NULL,
`startdate` datetime  NULL DEFAULT NULL,
`enddate` datetime  NULL DEFAULT NULL,

`average` int(10) NULL DEFAULT NULL,

`paydate` datetime  NULL DEFAULT NULL,
`payamount` int(10) NULL DEFAULT NULL,
`paybank` varchar(100)   NULL DEFAULT NULL,
`paytype` varchar(100)   NULL DEFAULT NULL,
`paynumber` varchar(100)   NULL DEFAULT NULL,

`gift` text   NULL DEFAULT NULL,
`desc` text   NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted', 'expire', 'lock', 'draft') NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_send_clergy_id` FOREIGN KEY (`clergy_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_adminoffice_id` FOREIGN KEY (`adminoffice_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_missionary_id` FOREIGN KEY (`missionary_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_servant_id` FOREIGN KEY (`servant_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,

CONSTRAINT `agent_send_place_id` FOREIGN KEY (`place_id`) REFERENCES `agent_place` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- assessment
CREATE TABLE `agent_assessment` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`send_id` int(10) UNSIGNED NOT NULL,

`assessmentor` int(10) UNSIGNED  NULL DEFAULT NULL,
`assessment_for` int(10) UNSIGNED  NULL DEFAULT NULL,

`job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant') NULL,
`job_for` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant') NULL,

`assessmentdate` datetime  NULL DEFAULT NULL,
`assessmentdesc` text   NULL DEFAULT NULL,

`score` int(10) NULL DEFAULT NULL,
`percent` int(10) NULL DEFAULT NULL,

`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_assessment_send_id` FOREIGN KEY (`send_id`) REFERENCES `agent_send` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_assessment_assessmentor` FOREIGN KEY (`assessmentor`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_assessment_assessment_for` FOREIGN KEY (`assessment_for`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- item feedback
CREATE TABLE `agent_assessmentitem` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`rate` int(10) NULL DEFAULT NULL,
`job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant') NULL,
`city` enum('qom', 'mashhad', 'karbala') NULL,
`sort` int(10) UNSIGNED NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- feedback detail
CREATE TABLE `agent_assessmentdetail` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`agent_send_id` int(10) UNSIGNED NOT NULL,
`assessment_id` int(10) UNSIGNED NOT NULL,
`assessmentitem_id` int(10) UNSIGNED NOT NULL,
`rate` int(10) UNSIGNED  NULL DEFAULT NULL,
`star` int(10) UNSIGNED  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_assessmentdetail_agent_send_id` FOREIGN KEY (`agent_send_id`) REFERENCES `agent_send` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_assessmentdetail_agent_assessment_id` FOREIGN KEY (`assessment_id`) REFERENCES `agent_assessment` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_assessmentdetail_assessmentitem_id` FOREIGN KEY (`assessmentitem_id`) REFERENCES `agent_assessmentitem` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

