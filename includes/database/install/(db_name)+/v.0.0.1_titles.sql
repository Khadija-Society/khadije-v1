CREATE TABLE `needs` (
`id`            int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`title`         varchar(200) CHARACTER SET utf8mb4 NOT NULL,
`request`       bigint(20) UNSIGNED NULL DEFAULT NULL,
`received`      bigint(20) UNSIGNED NULL DEFAULT NULL,
`amount`        int(10) UNSIGNED NULL DEFAULT NULL,
`type`          enum('product', 'expertise') NULL DEFAULT NULL,
`status`        enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`          text CHARACTER SET utf8mb4,
`meta`          mediumtext CHARACTER SET utf8mb4,
`fileurl`       varchar(1000) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`linkurl`       varchar(1000) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`datecreated`   timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `transactionneeds` (
`id`            	int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`transaction_id`  	bigint(20) UNSIGNED NOT NULL,
`need_id`  			int(10) UNSIGNED NOT NULL,
`count`		        int(10) UNSIGNED NULL DEFAULT NULL,
`desc`          	text CHARACTER SET utf8mb4,
`datecreated`   	timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  	timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `transactionneeds_unique` (`transaction_id`, `need_id`),
CONSTRAINT `transactionneeds_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactionneeds_need_id` FOREIGN KEY (`need_id`) REFERENCES `needs` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `nationalcodes` (
`id`            int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`nationalcode`  varchar(20) CHARACTER SET utf8mb4 NOT NULL,
`qom`	        smallint(3) UNSIGNED NULL DEFAULT NULL,
`mashhad`       smallint(3) UNSIGNED NULL DEFAULT NULL,
`karbala`       smallint(3) UNSIGNED NULL DEFAULT NULL,
`status`        enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`          text CHARACTER SET utf8mb4,
`datecreated`   timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `nationalcode_unique` (`nationalcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `travels` (
`id`            int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id`       int(10) UNSIGNED NOT NULL,
`place`         varchar(200) CHARACTER SET utf8mb4 NOT NULL,
`hotel`         varchar(200) CHARACTER SET utf8mb4 NULL,
`countpeople`   smallint(5) UNSIGNED NULL DEFAULT NULL,
`startdate`     varchar(20) NULL DEFAULT NULL,
`enddate`       varchar(20) NULL DEFAULT NULL,
`type`          enum('family', 'group') NULL DEFAULT NULL,
`status`        enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`          text CHARACTER SET utf8mb4,
`meta`          mediumtext CHARACTER SET utf8mb4,
`datecreated`   timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `travels_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `travelusers` (
`id`            int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`travel_id`     int(10) UNSIGNED NOT NULL,
`user_id`       int(10) UNSIGNED NOT NULL,
`status`        enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`          text CHARACTER SET utf8mb4,
`meta`          mediumtext CHARACTER SET utf8mb4,
`datecreated`   timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `travelusers_travel_id` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`) ON UPDATE CASCADE,
CONSTRAINT `travelusers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `transactions` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL;
ALTER TABLE `transactions` ADD `niyat` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `transactions` ADD `hazinekard` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `transactions` ADD `fullname` varchar(200) NULL DEFAULT NULL;


ALTER TABLE `users` ADD `firstname` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `lastname` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `father` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `nationalcode` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `age` smallint(3) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `pasportcode` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `pasportdate` varchar(20) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `education` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `educationcourse` varchar(200) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `city` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `province` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `country` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `village` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `homeaddress` varchar(1000) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `workaddress` varchar(1000) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `arabiclang` varchar(1000) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `phone` varchar(1000) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `expertise` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `workexperienceyear` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `workexperience` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `experiencedegree` varchar(100) NULL DEFAULT NULL;

