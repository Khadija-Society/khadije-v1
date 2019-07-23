ALTER TABLE `s_sms` ADD `smscount` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `text`;

UPDATE s_sms SET s_sms.smscount = LENGTH(s_sms.text);
