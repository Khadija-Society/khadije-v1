ALTER TABLE `users` ADD `married` enum('single', 'married') NULL DEFAULT NULL;
ALTER TABLE `users` ADD `zipcode` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `desc` text NULL DEFAULT NULL;
ALTER TABLE `users` ADD `job` varchar(100) NULL DEFAULT NULL;
