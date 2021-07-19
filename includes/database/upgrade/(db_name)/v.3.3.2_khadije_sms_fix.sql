ALTER TABLE `s_sms` ADD `textisnull` BIT(1) NULL DEFAULT NULL;
ALTER TABLE `s_sms` ADD INDEX `index_search_textisnull` (`textisnull`);
UPDATE s_sms SET s_sms.textisnull = 1 WHERE s_sms.text IS NULL;
ALTER TABLE `khadije`.`s_sms` ADD INDEX `mobile_id_platoon_textisnull` (`mobile_id`, `platoon`, `textisnull`);
