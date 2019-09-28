CREATE TABLE `mokebusers` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `displayname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `verifymobile` bit(1) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `verifyemail` bit(1) DEFAULT NULL,
  `chatid` int(20) UNSIGNED DEFAULT NULL,
  `tg_lastupdate` datetime DEFAULT NULL,
  `status` enum('active','awaiting','deactive','removed','filter','unreachable') DEFAULT 'awaiting',
  `avatar` varchar(2000) CHARACTER SET utf8mb4 DEFAULT NULL,
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
  `firstname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `father` varchar(100) DEFAULT NULL,
  `nationalcode` varchar(100) DEFAULT NULL,
  `age` smallint(3) DEFAULT NULL,
  `pasportcode` varchar(100) DEFAULT NULL,
  `pasportdate` varchar(20) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `educationcourse` varchar(200) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `village` varchar(100) DEFAULT NULL,
  `homeaddress` varchar(1000) DEFAULT NULL,
  `workaddress` varchar(1000) DEFAULT NULL,
  `arabiclang` varchar(1000) DEFAULT NULL,
  `phone` varchar(1000) DEFAULT NULL,
  `expertise` varchar(100) DEFAULT NULL,
  `workexperienceyear` varchar(100) DEFAULT NULL,
  `workexperience` varchar(100) DEFAULT NULL,
  `experiencedegree` varchar(100) DEFAULT NULL,
  `married` enum('single','married') DEFAULT NULL,
  `zipcode` varchar(100) DEFAULT NULL,
  `desc` text,
  `job` varchar(100) DEFAULT NULL,
  `iscompleteprofile` bit(1) DEFAULT NULL,
  `nesbat` varchar(100) DEFAULT NULL,
  `website` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `facebook` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `twitter` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `instagram` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `linkedin` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `gmail` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `sidebar` bit(1) DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4,
  `bookmylovestory` bit(1) DEFAULT NULL,
  `tgstatus` enum('active','deactive','spam','bot','block','unreachable','unknown','filter','awaiting','inline','callback') DEFAULT NULL,
  `tgusername` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `forceremember` bit(1) DEFAULT NULL,
  `signature` text CHARACTER SET utf8mb4,
  `nationality` varchar(5) DEFAULT NULL,
  `marital` enum('single','married') DEFAULT NULL,
  `foreign` bit(1) DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4,
  `android_version` varchar(200) DEFAULT NULL,
  `android_serial` varchar(200) DEFAULT NULL,
  `android_model` varchar(200) DEFAULT NULL,
  `android_manufacturer` varchar(200) DEFAULT NULL,
  `android_lastupdate` datetime DEFAULT NULL,
  `android_uniquecode` char(32) DEFAULT NULL,
  `android_meta` text CHARACTER SET utf8mb4
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for table `mokebusers`
--
ALTER TABLE `mokebusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_search_karbala2_mobile` (`mobile`),
  ADD KEY `index_search_karbala2_nationalcode` (`nationalcode`),
  ADD KEY `index_search_karbala2_pasportcode` (`pasportcode`),
  ADD KEY `index_search_karbala2_android_uniquecode` (`android_uniquecode`),
  ADD KEY `index_search_karbala2_email` (`email`),
  ADD KEY `index_search_karbala2_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mokebusers`
--
ALTER TABLE `mokebusers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;