

ALTER TABLE `agent_place` ADD `servant2_id` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_place` ADD CONSTRAINT `agent_place_servant2_id` FOREIGN KEY (`servant2_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;


ALTER TABLE `agent_userskills` ADD `rate` int(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `agent_userskills` ADD `desc` text  NULL DEFAULT NULL;
