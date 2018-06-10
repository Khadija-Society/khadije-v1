CREATE TABLE `salavats` (
`id`            bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id`       int(10) UNSIGNED NULL,
`datecreated`   timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `salavats_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
