ALTER TABLE `s_groupfilter` ADD `isdefault` bit(1) NULL DEFAULT NULL;
ALTER TABLE `s_sms` CHANGE `sendstatus` `sendstatus` enum('awaiting', 'sendtodevice', 'send', 'deliver', 'sendbypanel', 'waitingtoautosend') NULL DEFAULT NULL;
