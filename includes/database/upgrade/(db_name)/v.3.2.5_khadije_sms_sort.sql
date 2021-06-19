ALTER TABLE s_mobiles ADD `lastsmstime` INT(10) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE s_mobiles ADD INDEX `s_sms_index_search_lastsmstime` (`lastsmstime`);
UPDATE s_mobiles SET s_mobiles.lastsmstime = (SELECT UNIX_TIMESTAMP(MAX(s_sms.datecreated)) FROM s_sms WHERE s_sms.mobile_id = s_mobiles.id) WHERE s_mobiles.lastsmstime IS NULL;