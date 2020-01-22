

ALTER TABLE `agent_send` ADD `alertsms` varchar(500)  NULL DEFAULT NULL;
ALTER TABLE `agent_send` ADD `alertsmsdate` datetime  NULL DEFAULT NULL;

ALTER TABLE `agent_send` ADD `alertassessment_count` int(10)   NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `agent_send` ADD `alertassessment_date` datetime   NULL DEFAULT NULL AFTER `status`;

