ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_datecreated` (`datecreated`);
ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_answertextcount` (`answertextcount`);
ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_datesend` (`datesend`);
ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_sendstatus` (`sendstatus`);
ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_date` (`date`);
ALTER TABLE `s_sms` ADD INDEX `s_sms_index_search_smscount` (`smscount`);


ALTER TABLE `transactions` ADD INDEX `transactions_index_search_donate` (`donate`);
ALTER TABLE `transactions` ADD INDEX `transactions_index_search_plus` (`plus`);
ALTER TABLE `transactions` ADD INDEX `transactions_index_search_verify` (`verify`);
ALTER TABLE `transactions` ADD INDEX `transactions_index_search_datecreated` (`datecreated`);
ALTER TABLE `transactions` ADD INDEX `transactions_index_search_condition` (`condition`);