

ALTER TABLE `agent_place` ADD `servant2_id` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_place` ADD CONSTRAINT `agent_place_servant2_id` FOREIGN KEY (`servant2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_userskills` ADD `rate` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_userskills` ADD `desc` text  NULL DEFAULT NULL;




ALTER TABLE `agent_servant` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2') NULL;
ALTER TABLE `agent_assessment` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2') NULL;
ALTER TABLE `agent_assessment` CHANGE `job_for` `job_for` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2') NULL;

ALTER TABLE `agent_assessmentitem` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2') NULL;




ALTER TABLE `agent_send` ADD `maddah_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_maddah_id` FOREIGN KEY (`maddah_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;



ALTER TABLE `agent_send` ADD `nazer_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_nazer_id` FOREIGN KEY (`nazer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;



ALTER TABLE `agent_send` ADD `khadem_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_khadem_id` FOREIGN KEY (`khadem_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_send` ADD `khadem2_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_khadem2_id` FOREIGN KEY (`khadem2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;



ALTER TABLE `agent_send` ADD `servant2_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_servant2_id` FOREIGN KEY (`servant2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_send` ADD `title` varchar(200)  NULL DEFAULT NULL AFTER `id`;




ALTER TABLE `agent_servant` ADD `reject_count` int(10)   NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `agent_servant` ADD `reject_date` datetime   NULL DEFAULT NULL AFTER `status`;



CREATE TABLE `agent_file` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`send_id` int(10) UNSIGNED NOT NULL,
`creator` int(10) UNSIGNED  NULL DEFAULT NULL,

`job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2') NULL,

`file` varchar(500) NULL DEFAULT NULL,
`desc` text NULL DEFAULT NULL,

`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `agent_send_file_send_id` FOREIGN KEY (`send_id`) REFERENCES `agent_send` (`id`) ON UPDATE CASCADE,
CONSTRAINT `agent_send_file_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
