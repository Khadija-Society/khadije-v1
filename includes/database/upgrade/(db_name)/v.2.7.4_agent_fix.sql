

ALTER TABLE `agent_place` ADD `servant2_id` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_place` ADD CONSTRAINT `agent_place_servant2_id` FOREIGN KEY (`servant2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_userskills` ADD `rate` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_userskills` ADD `desc` text  NULL DEFAULT NULL;




ALTER TABLE `agent_servant` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem') NULL;
ALTER TABLE `agent_assessment` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem') NULL;
ALTER TABLE `agent_assessment` CHANGE `job_for` `job_for` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem') NULL;

ALTER TABLE `agent_assessmentitem` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem') NULL;




ALTER TABLE `agent_send` ADD `maddah_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_place_maddah_id` FOREIGN KEY (`maddah_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;



ALTER TABLE `agent_send` ADD `nazer_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_place_nazer_id` FOREIGN KEY (`nazer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;



ALTER TABLE `agent_send` ADD `khadem_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_place_khadem_id` FOREIGN KEY (`khadem_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_send` ADD `khadem2_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_place_khadem2_id` FOREIGN KEY (`khadem2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_send` ADD `title` varchar(200)  NULL DEFAULT NULL AFTER `id`;




ALTER TABLE `agent_servant` ADD `reject_count` int(10)   NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `agent_servant` ADD `reject_date` datetime   NULL DEFAULT NULL AFTER `status`;