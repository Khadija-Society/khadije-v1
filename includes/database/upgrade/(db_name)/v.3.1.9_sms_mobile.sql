CREATE TABLE `s_mobiles` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`mobile` varchar(100) NOT NULL,
`datecreated` datetime  NULL DEFAULT NULL,
PRIMARY KEY (`id`),
INDEX `s_mobiles_id` (`id`),
INDEX `s_mobiles_mobiles` (`mobile`),
UNIQUE `s_mobiles_unique` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT IGNORE INTO s_mobiles SELECT NULL, s_sms.fromnumber, s_sms.datecreated FROM s_sms;
INSERT IGNORE INTO s_mobiles SELECT NULL, s_sms.tonumber, s_sms.datecreated FROM s_sms;


ALTER TABLE s_sms ADD `mobile_id` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_sms ADD INDEX `s_sms_index_search_mobile_id` (`mobile_id`);


UPDATE s_sms SET s_sms.mobile_id = (SELECT s_mobiles.id FROM s_mobiles WHERE s_mobiles.mobile = s_sms.fromnumber LIMIT 1);


ALTER TABLE s_sms ADD `conversation_answered` BIT(1)  NULL DEFAULT NULL;
ALTER TABLE s_sms ADD INDEX `s_sms_index_search_conversation_answered` (`conversation_answered`);


UPDATE s_sms SET s_sms.conversation_answered = 1 WHERE  s_sms.answertext IS NOT NULL OR s_sms.receivestatus NOT IN ('awaiting', 'analyze');
UPDATE s_sms SET s_sms.conversation_answered = 1 WHERE  s_sms.answertext IS NOT NULL OR s_sms.receivestatus NOT IN ('awaiting', 'analyze');


ALTER TABLE s_group ADD `sort` int(10)  NULL DEFAULT NULL;
ALTER TABLE s_group ADD INDEX `s_group_index_search_sort` (`sort`);


ALTER TABLE s_group ADD `calcdate` datetime  NULL DEFAULT NULL;
ALTER TABLE s_group ADD INDEX `s_group_index_search_calcdate` (`calcdate`);



ALTER TABLE s_groupfilter ADD `sort` int(10)  NULL DEFAULT NULL;
ALTER TABLE s_groupfilter ADD INDEX `s_groupfilter_index_search_sort` (`sort`);
