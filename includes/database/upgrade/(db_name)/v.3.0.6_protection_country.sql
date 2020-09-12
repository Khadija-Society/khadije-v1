ALTER TABLE `protection_user_agent_occasion` ADD `country` varchar(50) NULL;
ALTER TABLE `protection_user_agent_occasion` ADD `pasportcode` varchar(100) NULL;

ALTER TABLE `protection_user_agent_occasion` ADD INDEX `index_search_mobile` (`mobile`);
ALTER TABLE `protection_user_agent_occasion` ADD INDEX `index_search_nationalcode` (`nationalcode`);
ALTER TABLE `protection_user_agent_occasion` ADD INDEX `index_search_pasportcode` (`pasportcode`);
ALTER TABLE `protection_user_agent_occasion` ADD INDEX `index_search_displayname` (`displayname`);



