
#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:20
	---0.075349092483521s		---75ms
	CREATE TABLE `users` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`username` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
`displayname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
`gender` enum('male','female') DEFAULT NULL,
`title` varchar(100) DEFAULT NULL,
`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
`mobile` varchar(15) DEFAULT NULL,
`email` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
`chatid` int(20) UNSIGNED DEFAULT NULL,
`status` enum('active','awaiting','deactive','removed','filter','unreachable') DEFAULT 'awaiting',
`avatar` varchar(2000) DEFAULT NULL,
`parent` int(10) UNSIGNED DEFAULT NULL,
`permission` varchar(1000) DEFAULT NULL,
`type` varchar(100) DEFAULT NULL,
`datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`pin` smallint(4) UNSIGNED DEFAULT NULL,
`ref` int(10) UNSIGNED DEFAULT NULL,
`twostep` bit(1) DEFAULT NULL,
`birthday` varchar(50) DEFAULT NULL,
`unit_id` smallint(5) DEFAULT NULL,
`language` char(2) DEFAULT NULL,
`meta` mediumtext CHARACTER SET utf8mb4,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:20
	---0.052621841430664s		---53ms
	CREATE TABLE `terms` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` char(2) DEFAULT NULL,
  `type` enum('cat','tag','code','other','term') DEFAULT NULL,
  `caller` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `url` varchar(1000) CHARACTER SET utf8mb4 DEFAULT NULL,
  `desc` mediumtext CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `parent` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('enable','disable','expired','awaiting','filtered','blocked','spam','violence','pornography','other') NOT NULL DEFAULT 'awaiting',
  `count` int(10) UNSIGNED DEFAULT NULL,
  `usercount` int(10) UNSIGNED DEFAULT NULL,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.14497804641724s		---145ms
	ALTER TABLE `terms` ADD PRIMARY KEY (`id`), ADD KEY `terms_users_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.15966105461121s		---160ms
	ALTER TABLE `terms` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.090083837509155s		---90ms
	ALTER TABLE `terms` ADD CONSTRAINT `terms_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.047056913375854s		---47ms
	CREATE TABLE `termusages` (
  `term_id` int(10) UNSIGNED NOT NULL,
  `related_id` bigint(20) UNSIGNED NOT NULL,
  `related` enum('posts','products','attachments','files','comments','users') DEFAULT NULL,
  `order` smallint(5) UNSIGNED DEFAULT NULL,
  `status` enum('enable','disable','expired','awaiting','filtered','blocked','spam','violence','pornography','other','deleted') NOT NULL DEFAULT 'enable',
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `type` enum('cat','tag','term','code','other','barcode1','barcode2','barcode3','qrcode1','qrcode2','qrcode3','rfid1','rfid2','rfid3','fingerprint1','fingerprint2','fingerprint3','fingerprint4','fingerprint5','fingerprint6','fingerprint7','fingerprint8','fingerprint9','fingerprint10') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.073587894439697s		---74ms
	ALTER TABLE `termusages` ADD KEY `term_id` (`term_id`), ADD KEY `related_id` (`related_id`), ADD KEY `related` (`related`), ADD KEY `status` (`status`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.045022010803223s		---45ms
	CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_idsender` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(500) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4,
  `url` varchar(2000) CHARACTER SET utf8mb4 DEFAULT NULL,
  `read` bit(1) DEFAULT NULL,
  `star` bit(1) DEFAULT NULL,
  `status` enum('awaiting','enable','disable','expire','deleted','cancel','block') DEFAULT NULL,
  `category` smallint(5) DEFAULT NULL,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `expiredate` datetime DEFAULT NULL,
  `readdate` datetime DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `telegram` bit(1) DEFAULT NULL,
  `telegramdate` datetime DEFAULT NULL,
  `sms` bit(1) DEFAULT NULL,
  `smsdate` datetime DEFAULT NULL,
  `smsdeliverdate` datetime DEFAULT NULL,
  `email` bit(1) DEFAULT NULL,
  `emaildate` datetime DEFAULT NULL,
  `related_foreign` varchar(50) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `needanswer` bit(1) DEFAULT NULL,
  `answer` smallint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.11615085601807s		---116ms
	ALTER TABLE `notifications` ADD PRIMARY KEY (`id`), ADD KEY `notifications_users_idsender` (`user_idsender`), ADD KEY `user_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.13135600090027s		---131ms
	ALTER TABLE `notifications` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.13268899917603s		---133ms
	ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_users_idsender` FOREIGN KEY (`user_idsender`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:21
	---0.041247129440308s		---41ms
	CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language` char(2) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `url` varchar(255) NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `type` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'post',
  `comment` enum('open','closed') DEFAULT NULL,
  `count` smallint(5) UNSIGNED DEFAULT NULL,
  `order` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('publish','draft','schedule','deleted','expire') NOT NULL DEFAULT 'draft',
  `parent` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `publishdate` datetime DEFAULT NULL,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.093274116516113s		---93ms
	ALTER TABLE `posts` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url_unique` (`url`,`language`) USING BTREE, ADD KEY `posts_users_id` (`user_id`) USING BTREE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.087490081787109s		---87ms
	ALTER TABLE `posts` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.10467290878296s		---105ms
	ALTER TABLE `posts` ADD CONSTRAINT `posts_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.038455963134766s		---38ms
	CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 NOT NULL,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `status` enum('approved','unapproved','spam','deleted') NOT NULL DEFAULT 'unapproved',
  `parent` smallint(5) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `minus` int(10) UNSIGNED DEFAULT NULL,
  `plus` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `visitor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.10100603103638s		---101ms
	ALTER TABLE `comments` ADD PRIMARY KEY (`id`), ADD KEY `comments_posts_id` (`post_id`) USING BTREE, ADD KEY `comments_users_id` (`user_id`) USING BTREE, ADD KEY `comments_visitors_id` (`visitor_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.17677617073059s		---177ms
	ALTER TABLE `comments` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.15315198898315s		---153ms
	ALTER TABLE `comments`
  ADD CONSTRAINT `comments_posts_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:22
	---0.040932893753052s		---41ms
	CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cat` varchar(100) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
  `value` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `status` enum('enable','disable','expire') NOT NULL DEFAULT 'enable',
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.12560987472534s		---126ms
	ALTER TABLE `options` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_cat` (`key`) USING BTREE, ADD KEY `options_users_id` (`user_id`), ADD KEY `options_posts_id` (`post_id`), ADD KEY `options_parent_id` (`parent_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.12365698814392s		---124ms
	ALTER TABLE `options` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.1013720035553s		---101ms
	ALTER TABLE `options`
  ADD CONSTRAINT `options_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `options` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `options_posts_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `options_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.084887027740479s		---85ms
	CREATE TABLE `logitems` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `caller` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `desc` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium',
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.096264839172363s		---96ms
	ALTER TABLE `logitems` ADD PRIMARY KEY (`id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.09775710105896s		---98ms
	ALTER TABLE `logitems` MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.051731824874878s		---52ms
	CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logitem_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `data` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `status` enum('enable','disable','expire','deliver') DEFAULT NULL,
  `desc` varchar(250) DEFAULT NULL,
  `createdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.1371021270752s		---137ms
	ALTER TABLE `logs` ADD PRIMARY KEY (`id`), ADD KEY `logs_users_id` (`user_id`) USING BTREE, ADD KEY `logs_logitems_id` (`logitem_id`) USING BTREE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:23
	---0.08759880065918s		---88ms
	ALTER TABLE `logs` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.12284898757935s		---123ms
	ALTER TABLE `logs`
  ADD CONSTRAINT `logs_logitems_id` FOREIGN KEY (`logitem_id`) REFERENCES `logitems` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `logs_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.055056810379028s		---55ms
	CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `user_id_seller` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `temp` bit(1) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `total` bigint(20) DEFAULT NULL,
  `total_discount` int(10) DEFAULT NULL,
  `status` enum('enable','disable','expire') NOT NULL DEFAULT 'enable',
  `date_pay` datetime DEFAULT NULL,
  `transaction_bank` varchar(255) DEFAULT NULL,
  `discount` int(10) DEFAULT NULL,
  `vat` int(10) DEFAULT NULL,
  `vat_pay` int(10) DEFAULT NULL,
  `final_total` bigint(20) DEFAULT NULL,
  `count_detail` smallint(5) UNSIGNED DEFAULT NULL,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `desc` text CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.1547269821167s		---155ms
	ALTER TABLE `invoices` ADD PRIMARY KEY (`id`), ADD KEY `inovoices_user_id` (`user_id`), ADD KEY `inovoices_user_id_seller` (`user_id_seller`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.12438797950745s		---124ms
	ALTER TABLE `invoices` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.17611598968506s		---176ms
	ALTER TABLE `invoices` ADD CONSTRAINT `inovoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE, ADD CONSTRAINT `inovoices_user_id_seller` FOREIGN KEY (`user_id_seller`) REFERENCES `users` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.053434133529663s		---53ms
	CREATE TABLE `invoice_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL,
  `price` int(10) DEFAULT NULL,
  `count` smallint(5) DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `discount` smallint(5) DEFAULT NULL,
  `status` enum('enable','disable','expire') NOT NULL DEFAULT 'enable',
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `desc` text CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.12980794906616s		---130ms
	ALTER TABLE `invoice_details` ADD PRIMARY KEY (`id`), ADD KEY `inovoices_id` (`invoice_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:24
	---0.085947036743164s		---86ms
	ALTER TABLE `invoice_details` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.099694967269897s		---100ms
	ALTER TABLE `invoice_details` ADD CONSTRAINT `inovoices_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.10020017623901s		---100ms
	CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(64) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','terminate','expire','disable','changed','logout') NOT NULL DEFAULT 'active',
  `agent_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` int(10) UNSIGNED DEFAULT NULL,
  `count` int(10) UNSIGNED DEFAULT '1',
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_seen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.21366310119629s		---214ms
--- CHECK!
	ALTER TABLE `sessions` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique` (`code`) USING BTREE, ADD KEY `sessions_user_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.13117098808289s		---131ms
	ALTER TABLE `sessions` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.095790147781372s		---96ms
	ALTER TABLE `sessions` ADD CONSTRAINT `sessions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.036457061767578s		---36ms
	CREATE TABLE `socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `social` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` enum('enable','expire','disable') NOT NULL DEFAULT 'enable',
  `email` varchar(255) DEFAULT NULL,
  `verified` bit(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `displayname` varchar(500) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `picture` varchar(1000) DEFAULT NULL,
  `hd` varchar(500) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `desc` text,
  `meta` mediumtext,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.08629584312439s		---86ms
	ALTER TABLE `socials` ADD PRIMARY KEY (`id`), ADD KEY `social_user_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.10189199447632s		---102ms
	ALTER TABLE `socials` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.099937915802002s		---100ms
	ALTER TABLE `socials` ADD CONSTRAINT `social_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.046860933303833s		---47ms
	CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` smallint(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `caller` varchar(100) DEFAULT NULL,
  `type` enum('gift','prize','transfer','promo','money') NOT NULL,
  `unit_id` smallint(3) NOT NULL,
  `amount_request` bigint(20) DEFAULT NULL,
  `amount_end` bigint(20) DEFAULT NULL,
  `plus` bigint(20) UNSIGNED DEFAULT NULL,
  `minus` bigint(20) UNSIGNED DEFAULT NULL,
  `budget_before` bigint(20) DEFAULT NULL,
  `budget` bigint(20) DEFAULT NULL,
  `status` enum('enable','disable','deleted','expired','awaiting','filtered','blocked','spam') NOT NULL DEFAULT 'enable',
  `condition` enum('request','redirect','cancel','pending','error','verify_request','verify_error','ok') DEFAULT NULL,
  `verify` bit(1) NOT NULL DEFAULT b'0',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `related_user_id` int(10) UNSIGNED DEFAULT NULL,
  `related_foreign` varchar(50) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `payment_response` text CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4,
  `desc` text CHARACTER SET utf8mb4,
  `dateverify` int(10) UNSIGNED NULL DEFAULT NULL,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.0833899974823s		---83ms
	ALTER TABLE `transactions` ADD PRIMARY KEY (`id`), ADD KEY `newtransactions_user_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.12803411483765s		---128ms
	ALTER TABLE `transactions` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.10437393188477s		---104ms
	ALTER TABLE `transactions` ADD CONSTRAINT `newtransactions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.052836894989014s		---53ms
	CREATE TABLE `userparents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent` int(10) UNSIGNED NOT NULL,
  `related_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
  `creator` int(10) UNSIGNED DEFAULT NULL,
  `level` smallint(5) DEFAULT NULL,
  `status` enum('enable','disable','expire','deleted') DEFAULT 'enable',
  `title` enum('father','mother','sister','brother','grandfather','grandmother','aunt','husband of the aunt','uncle','boy','girl','spouse','stepmother','stepfather','neighbor','teacher','friend','boss','supervisor','child','grandson','custom') DEFAULT NULL,
  `othertitle` varchar(255) DEFAULT NULL,
  `datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
  `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `desc` text CHARACTER SET utf8mb4,
  `meta` mediumtext CHARACTER SET utf8mb4
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.097516059875488s		---98ms
	ALTER TABLE `userparents` ADD PRIMARY KEY (`id`), ADD KEY `userparents_users_id` (`user_id`), ADD KEY `userparents_creator` (`creator`), ADD KEY `userparents_parent` (`parent`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.0905921459198s		---91ms
	ALTER TABLE `userparents` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.10769701004028s		---108ms
	ALTER TABLE `userparents`
  ADD CONSTRAINT `userparents_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userparents_parent` FOREIGN KEY (`parent`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userparents_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:26
	---0.047338008880615s		---47ms
	CREATE TABLE `contacts` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` int(10) UNSIGNED NOT NULL,
`key` varchar(100) NOT NULL,
`value` varchar(100) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`desc` varchar(1000) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`login` bit(1) NULL DEFAULT NULL,
`verify` bit(1) NULL DEFAULT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `contact_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.039146900177002s		---39ms
	CREATE TABLE `agents` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`agent` text NOT NULL,
`group` varchar(50) DEFAULT NULL,
`name` varchar(50) DEFAULT NULL,
`version` varchar(50) DEFAULT NULL,
`os` varchar(50) DEFAULT NULL,
`osnum` varchar(50) DEFAULT NULL,
`robot` bit(1) DEFAULT NULL,
`meta` text,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.036727905273438s		---37ms
	CREATE TABLE `needs` (
`id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`title`   varchar(200) CHARACTER SET utf8mb4 NOT NULL,
`request`   bigint(20) UNSIGNED NULL DEFAULT NULL,
`received`  bigint(20) UNSIGNED NULL DEFAULT NULL,
`amount`    int(10) UNSIGNED NULL DEFAULT NULL,
`type`    enum('product', 'expertise') NULL DEFAULT NULL,
`status`    enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`    text CHARACTER SET utf8mb4,
`meta`    mediumtext CHARACTER SET utf8mb4,
`fileurl`   varchar(1000) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`linkurl`   varchar(1000) CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.060086011886597s		---60ms
	CREATE TABLE `transactionneeds` (
`id`    	int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`transaction_id`  	bigint(20) UNSIGNED NOT NULL,
`need_id`  	int(10) UNSIGNED NOT NULL,
`count`		    int(10) UNSIGNED NULL DEFAULT NULL,
`desc`    	text CHARACTER SET utf8mb4,
`datecreated` 	timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  	timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `transactionneeds_unique` (`transaction_id`, `need_id`),
CONSTRAINT `transactionneeds_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactionneeds_need_id` FOREIGN KEY (`need_id`) REFERENCES `needs` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.11948299407959s		---119ms
	CREATE TABLE `nationalcodes` (
`id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`nationalcode`  varchar(20) CHARACTER SET utf8mb4 NOT NULL,
`qom`	    smallint(3) UNSIGNED NULL DEFAULT NULL,
`mashhad`   smallint(3) UNSIGNED NULL DEFAULT NULL,
`karbala`   smallint(3) UNSIGNED NULL DEFAULT NULL,
`status`    enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`    text CHARACTER SET utf8mb4,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `nationalcode_unique` (`nationalcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.080893993377686s		---81ms
	CREATE TABLE `travels` (
`id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id`   int(10) UNSIGNED NOT NULL,
`place`   varchar(200) CHARACTER SET utf8mb4 NOT NULL,
`hotel`   varchar(200) CHARACTER SET utf8mb4 NULL,
`countpeople` smallint(5) UNSIGNED NULL DEFAULT NULL,
`startdate`   varchar(20) NULL DEFAULT NULL,
`enddate`   varchar(20) NULL DEFAULT NULL,
`type`    enum('family', 'group') NULL DEFAULT NULL,
`status`    enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`    text CHARACTER SET utf8mb4,
`meta`    mediumtext CHARACTER SET utf8mb4,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `travels_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.054770946502686s		---55ms
	CREATE TABLE `travelusers` (
`id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`travel_id`   int(10) UNSIGNED NOT NULL,
`user_id`   int(10) UNSIGNED NOT NULL,
`status`    enum('enable','disable','expire','deleted','lock','awaiting') NOT NULL DEFAULT 'enable',
`desc`    text CHARACTER SET utf8mb4,
`meta`    mediumtext CHARACTER SET utf8mb4,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `travelusers_travel_id` FOREIGN KEY (`travel_id`) REFERENCES `travels` (`id`) ON UPDATE CASCADE,
CONSTRAINT `travelusers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:27
	---0.12648797035217s		---126ms
	ALTER TABLE `transactions` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:28
	---0.5963351726532s		---596ms
--- WARN!
	ALTER TABLE `transactions` ADD `niyat` varchar(200) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:28
	---0.12540411949158s		---125ms
	ALTER TABLE `transactions` ADD `hazinekard` varchar(200) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:28
	---0.14148998260498s		---141ms
	ALTER TABLE `users` ADD `firstname` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:28
	---0.1019299030304s		---102ms
	ALTER TABLE `users` ADD `lastname` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:28
	---0.18355298042297s		---184ms
	ALTER TABLE `users` ADD `father` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.12277793884277s		---123ms
	ALTER TABLE `users` ADD `nationalcode` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.11258411407471s		---113ms
	ALTER TABLE `users` ADD `age` smallint(3) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.077113151550293s		---77ms
	ALTER TABLE `users` ADD `pasportcode` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.13262009620667s		---133ms
	ALTER TABLE `users` ADD `pasportdate` varchar(20) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.14407396316528s		---144ms
	ALTER TABLE `users` ADD `education` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.096895933151245s		---97ms
	ALTER TABLE `users` ADD `educationcourse` varchar(200) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.10527896881104s		---105ms
	ALTER TABLE `users` ADD `city` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.078310012817383s		---78ms
	ALTER TABLE `users` ADD `province` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:29
	---0.070871829986572s		---71ms
	ALTER TABLE `users` ADD `country` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.099618911743164s		---100ms
	ALTER TABLE `users` ADD `village` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.085338115692139s		---85ms
	ALTER TABLE `users` ADD `homeaddress` varchar(1000) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.1192319393158s		---119ms
	ALTER TABLE `users` ADD `workaddress` varchar(1000) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.20687580108643s		---207ms
--- CHECK!
	ALTER TABLE `users` ADD `arabiclang` varchar(1000) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.16103291511536s		---161ms
	ALTER TABLE `users` ADD `phone` varchar(1000) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.16097593307495s		---161ms
	ALTER TABLE `users` ADD `expertise` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.09121298789978s		---91ms
	ALTER TABLE `users` ADD `workexperienceyear` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:31
	---0.072887897491455s		---73ms
	ALTER TABLE `users` ADD `workexperience` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:31
	---0.080006837844849s		---80ms
	ALTER TABLE `users` ADD `experiencedegree` varchar(100) NULL DEFAULT NULL

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:31
	---0.00096702575683594s		---1ms
	SELECT * FROM users WHERE `mobile` = '989357269759' AND `permission` = 'admin' LIMIT 1

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:31
	---0.0041019916534424s		---4ms
	INSERT INTO users SET `mobile` = 989357269759 , `permission` = 'admin'

#---------------------------------------------------------------------- /enter
---2017-12-26 12:51:16
	---0.00084400177001953s		---1ms
	SELECT * FROM users WHERE users.email = '9357269759' OR users.username = '9357269759' OR users.mobile = '989357269759' LIMIT 1

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.0033280849456787s		---3ms
	SELECT * FROM logs WHERE `user_id` = '1' AND `status` = 'enable' AND logs.logitem_id = (SELECT logitems.id FROM logitems WHERE logitems.caller = 'user:verification:code' LIMIT 1) LIMIT 1

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.00060701370239258s		---1ms
	SELECT id FROM logitems WHERE logitems.caller = 'user:verification:code' LIMIT 1

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.003680944442749s		---4ms
	INSERT INTO logitems SET `caller` = 'user:verification:code' , `title` = 'user:verification:code'

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.00052690505981445s		---1ms
	SELECT id AS `id` FROM logitems WHERE logitems.caller = 'user:verification:code' LIMIT 1

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.006425142288208s		---6ms
	INSERT IGNORE INTO logs SET  `logitem_id` = 18 , `user_id` = 1 , `data` = 11111 , `status` = 'enable' , `meta` = '{"session":{"user_country_ir_redirect_fa":true,"enter":{"usernameormobile":"9357269759","user_data":{"id":"1","username":null,"displayname":null,"gender":null,"title":null,"password":null,"mobile":"989357269759","email":null,"chatid":null,"status":"awaiting","avatar":null,"parent":null,"permission":"admin","type":null,"datecreated":"2017-12-26 12:50:31","datemodified":null,"pin":null,"ref":null,"twostep":null,"birthday":null,"unit_id":null,"language":null,"meta":null,"firstname":null,"lastname":null,"father":null,"nationalcode":null,"age":null,"pasportcode":null,"pasportdate":null,"education":null,"educationcourse":null,"city":null,"province":null,"country":null,"village":null,"homeaddress":null,"workaddress":null,"arabiclang":null,"phone":null,"expertise":null,"workexperienceyear":null,"workexperience":null,"experiencedegree":null},"temp_ramz":"Pc122333","temp_ramz_hash":"$2y$07$6Wk4D8yLJxfidhlAxXr3HefNXKiZocwmuTxV5CzVYjXJJ0KKCAAOW","verify_from":"set","code_is_created":true,"verification_code":11111},"step":{"usernameormobile":true,"pass":true},"lock":{"pass\/set":false,"pass\/recovery":false,"verify":false},"try":{"diffrent_mobile":1}}}' , `datecreated` = '2017-12-26 12:52:06'

#---------------------------------------------------------------------- /enter/verify
---2017-12-26 12:52:06
	---0.0034539699554443s		---3ms
	UPDATE logs SET `desc` = 'telegram' WHERE logs.id = 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:07
	---0.00043702125549316s		---0ms
	SELECT id FROM logitems WHERE logitems.caller = 'enter:send:sems:result' LIMIT 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:07
	---0.0032498836517334s		---3ms
	INSERT INTO logitems SET `caller` = 'enter:send:sems:result' , `title` = 'enter:send:sems:result'

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:07
	---0.00048685073852539s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.caller = 'enter:send:sems:result' LIMIT 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:07
	---0.0036060810089111s		---4ms
	INSERT IGNORE INTO logs SET  `logitem_id` = 19 , `user_id` = 1 , `data` = 11111 , `status` = 'enable' , `meta` = '{"mobile":"989357269759","code":11111,"session":{"user_country_ir_redirect_fa":true,"enter":{"usernameormobile":"9357269759","user_data":{"id":"1","username":null,"displayname":null,"gender":null,"title":null,"password":null,"mobile":"989357269759","email":null,"chatid":null,"status":"awaiting","avatar":null,"parent":null,"permission":"admin","type":null,"datecreated":"2017-12-26 12:50:31","datemodified":null,"pin":null,"ref":null,"twostep":null,"birthday":null,"unit_id":null,"language":null,"meta":null,"firstname":null,"lastname":null,"father":null,"nationalcode":null,"age":null,"pasportcode":null,"pasportdate":null,"education":null,"educationcourse":null,"city":null,"province":null,"country":null,"village":null,"homeaddress":null,"workaddress":null,"arabiclang":null,"phone":null,"expertise":null,"workexperienceyear":null,"workexperience":null,"experiencedegree":null},"temp_ramz":"Pc122333","temp_ramz_hash":"$2y$07$6Wk4D8yLJxfidhlAxXr3HefNXKiZocwmuTxV5CzVYjXJJ0KKCAAOW","verify_from":"set","code_is_created":true,"verification_code":11111,"verification_code_time":"2017-12-26 12:52:06","verification_code_way":"telegram","verification_code_id":1,"run_send_sms_code":true},"step":{"usernameormobile":true,"pass":true},"lock":{"pass\/set":false,"pass\/recovery":false,"verify":false,"verify\/sms":false},"try":{"diffrent_mobile":1}},"response":[]}' , `datecreated` = '2017-12-26 12:52:07'

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0048410892486572s		---5ms
	UPDATE logs SET `status` = 'expire' WHERE logs.id = 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0044229030609131s		---4ms
	UPDATE users SET `password` = '$2y$07$6Wk4D8yLJxfidhlAxXr3HefNXKiZocwmuTxV5CzVYjXJJ0KKCAAOW' WHERE users.id = 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0007469654083252s		---1ms
	SELECT * FROM users WHERE `id` = '1' LIMIT 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0028951168060303s		---3ms
	SELECT * FROM agents WHERE `agent` = 'Mozilla%2F5.0+%28Windows+NT+10.0%3B+Win64%3B+x64%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F62.0.3202.94+Safari%2F537.36+OPR%2F49.0.2725.56' LIMIT 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0044028759002686s		---4ms
	INSERT INTO agents SET  `agent` = 'Mozilla%2F5.0+%28Windows+NT+10.0%3B+Win64%3B+x64%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F62.0.3202.94+Safari%2F537.36+OPR%2F49.0.2725.56' , `group` = 'blink' , `name` = 'opera' , `version` = '49.0.2725.56' , `os` = 'nt' , `osnum` = 10.0 , `meta` = '{"browser_working":"blink","browser_number":"49.0.2725.56","ie_version":"","dom":true,"safe":true,"os":"nt","os_number":"10.0","browser_name":"opera","ua_type":"bro","browser_math_number":"49.0","moz_data":["","","","",""],"webkit_data":["","","49.0.2725.56"],"mobile_test":"","mobile_data":"","true_ie_number":"","run_time":"0.00029492","html_type":3,"engine_data":["blink","537.36","49.0"],"trident_data":["","","49.0","49.0.2725.56"],"blink_data":["opr\/","49.0.2725.56","49.0.2725.56"]}' , `robot` = NULL

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0022900104522705s		---2ms
	SELECT * FROM sessions WHERE `ip` = '2130706433' AND `agent_id` = 1 AND `user_id` = '1' AND `status` = 'active' LIMIT 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.0051560401916504s		---5ms
	INSERT INTO sessions SET `ip` = 2130706433 , `agent_id` = 1 , `user_id` = 1 , `status` = 'active' , `code` = '$2y$07$o65SrYVY2AwcD6olNIQHhu5dnDWOIgKZKprvrZyEhwC3ZnjAapy8G' , `last_seen` = '2017-12-26 12:52:10'

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.003446102142334s		---3ms
	UPDATE users SET `status` = 'active' WHERE users.id = 1

#---------------------------------------------------------------------- /enter/verify/sms
---2017-12-26 12:52:10
	---0.00079202651977539s		---1ms
	SELECT * FROM users WHERE `id` = '1' LIMIT 1

#---------------------------------------------------------------------- /su/tools
---2017-12-26 12:52:22
	---0.00083208084106445s		---1ms
	SELECT * FROM users WHERE `id` = '1' LIMIT 1

#---------------------------------------------------------------------- /su/tools/translation
---2017-12-26 12:52:25
	---0.00071310997009277s		---1ms
	SELECT * FROM users WHERE `id` = '1' LIMIT 1

#---------------------------------------------------------------------- /su/tools/translation?path=current
---2017-12-26 12:52:28
	---0.00076794624328613s		---1ms
	SELECT * FROM users WHERE `id` = '1' LIMIT 1
