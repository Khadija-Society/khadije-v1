CREATE TABLE `product` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`subtitle` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`file` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`price` int(10) UNSIGNED NULL DEFAULT NULL,
`need` int(10) UNSIGNED NULL DEFAULT NULL,
`sort` int(10) UNSIGNED NULL DEFAULT NULL,
`status` enum('enable', 'disable', 'deleted', 'publish')  NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `productdonate` (
`id` int(10) UNSIGNED NOT NULL auto_increment,
`user_id` int(10) UNSIGNED NULL DEFAULT NULL,
`product_id` int(10) UNSIGNED NULL DEFAULT NULL,
`count` int(10) UNSIGNED NULL DEFAULT NULL,
`price` int(10) UNSIGNED NULL DEFAULT NULL,
`total` int(10) UNSIGNED NULL DEFAULT NULL,
`transaction_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
`datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `productdoante_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `productdoante_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE,
CONSTRAINT `productdoante_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `transactions` ADD `isproduct` bit(1)  NULL DEFAULT NULL;