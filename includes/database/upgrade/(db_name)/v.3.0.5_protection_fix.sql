ALTER TABLE `protection_user_agent_occasion` CHANGE `status` `status` enum('request', 'pending', 'enable', 'block', 'deleted') NULL;
