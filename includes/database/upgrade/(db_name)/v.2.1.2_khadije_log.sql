CREATE DATABASE if not exists `khadije_log` DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `khadije_log`.`agents` (
`id` int(10) UNSIGNED NOT NULL,
`agent` text NOT NULL,
`group` varchar(50) DEFAULT NULL,
`name` varchar(50) DEFAULT NULL,
`version` varchar(50) DEFAULT NULL,
`os` varchar(50) DEFAULT NULL,
`osnum` varchar(50) DEFAULT NULL,
`robot` bit(1) DEFAULT NULL,
`meta` text,
`datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logitems`
--

CREATE TABLE `khadije_log`.`logitems` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `khadije_log`.`logs` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `khadije_log`.`services` (
`id` int(10) UNSIGNED NOT NULL,
`name` varchar(50) NOT NULL,
`subdomain` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `khadije_log`.`urls` (
`id` bigint(20) UNSIGNED NOT NULL,
`url` text NOT NULL,
`host` varchar(200) DEFAULT NULL,
`domain` varchar(500) DEFAULT NULL,
`query` text,
`urlmd5` varchar(32) DEFAULT NULL,
`pwd` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `khadije_log`.`visitors` (
`id` bigint(20) UNSIGNED NOT NULL,
`service_id` int(10) UNSIGNED DEFAULT NULL,
`visitor_ip` int(10) UNSIGNED DEFAULT NULL,
`url_id` bigint(20) UNSIGNED NOT NULL,
`url_idreferer` bigint(20) UNSIGNED DEFAULT NULL,
`agent_id` int(10) UNSIGNED DEFAULT NULL,
`user_id` int(10) UNSIGNED DEFAULT NULL,
`user_idteam` bigint(20) UNSIGNED DEFAULT NULL,
`external` bit(1) DEFAULT NULL,
`date` date NOT NULL,
`time` time NOT NULL,
`timeraw` int(10) UNSIGNED DEFAULT NULL,
`year` int(4) DEFAULT NULL,
`month` int(2) DEFAULT NULL,
`day` int(2) DEFAULT NULL,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `khadije_log`.`agents`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logitems`
--
ALTER TABLE `khadije_log`.`logitems`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `khadije_log`.`logs`
ADD PRIMARY KEY (`id`),
ADD KEY `logs_logitems_id` (`logitem_id`) USING BTREE;

--
-- Indexes for table `services`
--
ALTER TABLE `khadije_log`.`services`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `urls`
--
ALTER TABLE `khadije_log`.`urls`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `khadije_log`.`visitors`
ADD PRIMARY KEY (`id`),
ADD KEY `visitorip_index` (`visitor_ip`) USING BTREE,
ADD KEY `url_id` (`url_id`),
ADD KEY `visitors_urls_referer` (`url_idreferer`),
ADD KEY `visitors_agents` (`agent_id`),
ADD KEY `visitors_services` (`service_id`),
ADD KEY `visitor_date` (`date`),
ADD KEY `visitor_timeraw` (`timeraw`),
ADD KEY `year` (`year`),
ADD KEY `month` (`month`),
ADD KEY `day` (`day`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `khadije_log`.`agents`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `logitems`
--
ALTER TABLE `khadije_log`.`logitems`
MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `khadije_log`.`logs`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `khadije_log`.`services`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `khadije_log`.`urls`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `khadije_log`.`visitors`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `khadije_log`.`logs`
ADD CONSTRAINT `logs_logitems_id` FOREIGN KEY (`logitem_id`) REFERENCES `logitems` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `khadije_log`.`visitors`
ADD CONSTRAINT `visitors_agents` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `visitors_services` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `visitors_urls` FOREIGN KEY (`url_id`) REFERENCES `urls` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `visitors_urls_referer` FOREIGN KEY (`url_idreferer`) REFERENCES `urls` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
