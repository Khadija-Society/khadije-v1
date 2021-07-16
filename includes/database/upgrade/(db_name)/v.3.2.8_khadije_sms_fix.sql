ALTER TABLE s_mobiles ADD `platoon_1` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_1` (`platoon_1`);
ALTER TABLE s_mobiles ADD `platoon_1_lastsmstime` INT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_1_lastsmstime` (`platoon_1_lastsmstime`);
ALTER TABLE s_mobiles ADD `platoon_1_count` INT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_1_lasttext` TEXT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_2` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_2` (`platoon_2`);
ALTER TABLE s_mobiles ADD `platoon_2_lastsmstime` INT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_2_lastsmstime` (`platoon_2_lastsmstime`);
ALTER TABLE s_mobiles ADD `platoon_2_count` INT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_2_lasttext` TEXT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_3` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_3` (`platoon_3`);
ALTER TABLE s_mobiles ADD `platoon_3_lastsmstime` INT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_3_lastsmstime` (`platoon_3_lastsmstime`);
ALTER TABLE s_mobiles ADD `platoon_3_count` INT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_3_lasttext` TEXT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_4` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_4` (`platoon_4`);
ALTER TABLE s_mobiles ADD `platoon_4_lastsmstime` INT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_4_lastsmstime` (`platoon_4_lastsmstime`);
ALTER TABLE s_mobiles ADD `platoon_4_count` INT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_4_lasttext` TEXT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_5` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_5` (`platoon_5`);
ALTER TABLE s_mobiles ADD `platoon_5_lastsmstime` INT UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_5_lastsmstime` (`platoon_5_lastsmstime`);
ALTER TABLE s_mobiles ADD `platoon_5_count` INT NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD `platoon_5_lasttext` TEXT NULL DEFAULT NULL;

ALTER TABLE s_mobiles ADD `platoon_1_conversation_answered` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_1_conversation_answered` (`platoon_1_conversation_answered`);
ALTER TABLE s_mobiles ADD `platoon_2_conversation_answered` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_2_conversation_answered` (`platoon_2_conversation_answered`);
ALTER TABLE s_mobiles ADD `platoon_3_conversation_answered` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_3_conversation_answered` (`platoon_3_conversation_answered`);
ALTER TABLE s_mobiles ADD `platoon_4_conversation_answered` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_4_conversation_answered` (`platoon_4_conversation_answered`);
ALTER TABLE s_mobiles ADD `platoon_5_conversation_answered` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_platoon_5_conversation_answered` (`platoon_5_conversation_answered`);






ALTER TABLE s_mobiles ADD `realmobile` bit(1) NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobiles_index_search_realmobile` (`realmobile`);
UPDATE s_mobiles SET s_mobiles.realmobile = 1 WHERE  LENGTH(s_mobiles.mobile) = 12;


UPDATE s_mobiles SET s_mobiles.platoon_1 = 1 WHERE s_mobiles.mobile IN (SELECT s_sms.fromnumber FROM s_sms WHERE s_sms.platoon = '1');
UPDATE s_mobiles SET s_mobiles.platoon_2 = 1 WHERE s_mobiles.mobile IN (SELECT s_sms.fromnumber FROM s_sms WHERE s_sms.platoon = '2');


UPDATE s_mobiles SET s_mobiles.platoon_1_lastsmstime = (SELECT UNIX_TIMESTAMP(MAX(s_sms.date)) FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.fromnumber = s_mobiles.mobile GROUP BY s_sms.mobile_id) WHERE s_mobiles.platoon_1 = 1;
UPDATE s_mobiles SET s_mobiles.platoon_2_lastsmstime = (SELECT UNIX_TIMESTAMP(MAX(s_sms.date)) FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.fromnumber = s_mobiles.mobile GROUP BY s_sms.mobile_id) WHERE s_mobiles.platoon_2 = 1;


UPDATE s_mobiles SET s_mobiles.platoon_1_conversation_answered = (SELECT s_sms.conversation_answered FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_1 = 1;
UPDATE s_mobiles SET s_mobiles.platoon_2_conversation_answered = (SELECT s_sms.conversation_answered FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_2 = 1;

UPDATE s_mobiles SET s_mobiles.platoon_1_count = (SELECT COUNT(*) FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.fromnumber = s_mobiles.mobile) WHERE s_mobiles.platoon_1 = 1;
UPDATE s_mobiles SET s_mobiles.platoon_2_count = (SELECT COUNT(*) FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.fromnumber = s_mobiles.mobile) WHERE s_mobiles.platoon_2 = 1;


UPDATE s_mobiles SET s_mobiles.platoon_1_lasttext = (SELECT s_sms.text FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_1 = 1;
UPDATE s_mobiles SET s_mobiles.platoon_2_lasttext = (SELECT s_sms.text FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_2 = 1;



ALTER TABLE s_mobiles ADD `user_id` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_mobile_index_search_user_id` (`user_id`);
UPDATE s_mobiles SET s_mobiles.user_id = (SELECT users.id FROM users WHERE users.mobile = s_mobiles.mobile LIMIT 1) WHERE s_mobiles.user_id IS NOT NULL;


