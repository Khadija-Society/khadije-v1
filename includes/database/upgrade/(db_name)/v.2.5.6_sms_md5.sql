ALTER TABLE `s_sms` ADD `md5` char(32) NULL DEFAULT NULL;

ALTER TABLE `s_sms` ADD INDEX `index_search_md5` (`md5`);

