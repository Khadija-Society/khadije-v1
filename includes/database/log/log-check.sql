
#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:25
	---0.21366310119629s		---214ms
--- CHECK!
	ALTER TABLE `sessions` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique` (`code`) USING BTREE, ADD KEY `sessions_user_id` (`user_id`)

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-12-26 12:50:30
	---0.20687580108643s		---207ms
--- CHECK!
	ALTER TABLE `users` ADD `arabiclang` varchar(1000) NULL DEFAULT NULL
