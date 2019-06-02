CREATE TABLE `doyon` (
`id`        int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`seyyed`    bit(1) NULL DEFAULT NULL,
`title`     varchar(200) CHARACTER SET utf8mb4 NULL,
`type`      varchar(200) CHARACTER SET utf8mb4 NULL,
`count`     int(10) UNSIGNED  NULL,
`priceone`  int(10) UNSIGNED  NULL,
`price`     int(10) UNSIGNED  NULL,
`status`    enum('draft', 'awaiting', 'pay') NULL,
`user_id`   int(10) UNSIGNED NULL DEFAULT NULL,

PRIMARY KEY (`id`),
CONSTRAINT `doyon_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

