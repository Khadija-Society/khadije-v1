





ALTER TABLE `agent_servant` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2', 'rabet') NULL;
ALTER TABLE `agent_assessment` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2', 'rabet') NULL;
ALTER TABLE `agent_assessment` CHANGE `job_for` `job_for` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2', 'rabet') NULL;
ALTER TABLE `agent_assessmentitem` CHANGE `job` `job` enum('clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah', 'nazer', 'khadem', 'khadem2', 'rabet') NULL;




ALTER TABLE `agent_send` ADD `rabet_id` int(10) UNSIGNED NULL DEFAULT NULL AFTER `servant_id`;
ALTER TABLE `agent_send` ADD CONSTRAINT `agent_sendxn_rabet_id` FOREIGN KEY (`rabet_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

