ALTER TABLE `users` CHANGE `married` `married` ENUM('single','married','leave','dead') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` ADD `child` int(10)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shcode` int(10)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shfrom` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `birthcity` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `bank` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `hesab` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `shaba` varchar(200)  NULL DEFAULT NULL;
ALTER TABLE `users` ADD `card` varchar(200)  NULL DEFAULT NULL;

