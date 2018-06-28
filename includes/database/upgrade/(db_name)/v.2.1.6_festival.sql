CREATE TABLE `festivals` (
`id`          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`creator`     int(10) UNSIGNED NOT NULL,
`title`       varchar(500) CHARACTER SET utf8mb4 NULL,
`subtitle`    varchar(500) CHARACTER SET utf8mb4 NULL,
`slug`        varchar(200) CHARACTER SET utf8mb4 NULL,
`desc`        mediumtext CHARACTER SET utf8mb4,
`intro`       mediumtext CHARACTER SET utf8mb4,
`about`       mediumtext CHARACTER SET utf8mb4,
`target`      mediumtext CHARACTER SET utf8mb4,
`axis`        mediumtext CHARACTER SET utf8mb4,
`view`        mediumtext CHARACTER SET utf8mb4,
`schedule`    mediumtext CHARACTER SET utf8mb4,
`logo`        mediumtext CHARACTER SET utf8mb4,
`gallery`     mediumtext CHARACTER SET utf8mb4,
`place`       text CHARACTER SET utf8mb4,
`award`   	  mediumtext CHARACTER SET utf8mb4,
`phone`       text CHARACTER SET utf8mb4,
`address`     text CHARACTER SET utf8mb4,
`email`       text CHARACTER SET utf8mb4,
`sms`         varchar(500) CHARACTER SET utf8mb4,
`telegram`    varchar(500) CHARACTER SET utf8mb4,
`facebook`    varchar(500) CHARACTER SET utf8mb4,
`twitter`     varchar(500) CHARACTER SET utf8mb4,
`instagram`   varchar(500) CHARACTER SET utf8mb4,
`linkedin`   varchar(500) CHARACTER SET utf8mb4,
`website`     varchar(500) CHARACTER SET utf8mb4,
`poster`      text CHARACTER SET utf8mb4,
`brochure`    text CHARACTER SET utf8mb4,
`status`      enum('draft','awaiting','enable','expire','cancel', 'deleted', 'disable') NOT NULL DEFAULT 'draft',
`message`     text CHARACTER SET utf8mb4,
`messagesms`  text CHARACTER SET utf8mb4,
`freeuser`    bit(1) NULL DEFAULT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `festivals_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `festivaldetails` (
`id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`festival_id` int(10) UNSIGNED NOT NULL,
`creator`     int(10) UNSIGNED NOT NULL,
`title`       varchar(500) CHARACTER SET utf8mb4 NULL,
`subtitle`    varchar(500) CHARACTER SET utf8mb4 NULL,
`desc`        text CHARACTER SET utf8mb4,
`website`     varchar(500) CHARACTER SET utf8mb4,
`type`        varchar(100) CHARACTER SET utf8mb4,
`logo`        text CHARACTER SET utf8mb4,
`status`      enum('draft','awaiting','enable','expire','cancel', 'deleted', 'disable') NOT NULL DEFAULT 'draft',
`sms`         varchar(500) CHARACTER SET utf8mb4,
`telegram`    varchar(500) CHARACTER SET utf8mb4,
`facebook`    varchar(500) CHARACTER SET utf8mb4,
`twitter`     varchar(500) CHARACTER SET utf8mb4,
`instagram`   varchar(500) CHARACTER SET utf8mb4,
`linkedin`   varchar(500) CHARACTER SET utf8mb4,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `festivaldetails_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `festivaldetails_festival_id` FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `festivalcourses` (
`id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`festival_id` int(10) UNSIGNED NOT NULL,
`creator`     int(10) UNSIGNED NOT NULL,
`title`       varchar(500) CHARACTER SET utf8mb4 NULL,
`subtitle`    varchar(500) CHARACTER SET utf8mb4 NULL,
`condition`   mediumtext CHARACTER SET utf8mb4,
`conditionsend`   mediumtext CHARACTER SET utf8mb4,
`group`        varchar(500) CHARACTER SET utf8mb4,
`desc`        text CHARACTER SET utf8mb4,
`price`       int(10) UNSIGNED NULL DEFAULT NULL,
`allowfile`   mediumtext CHARACTER SET utf8mb4,
`multiuse`    bit(1) NULL DEFAULT NULL,
`score`        text CHARACTER SET utf8mb4,
`link`        text CHARACTER SET utf8mb4,
`status`      enum('draft','awaiting','enable','expire','cancel', 'deleted', 'disable') NOT NULL DEFAULT 'draft',
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `festivalcourses_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `festivalcourses_festival_id` FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `festivalusers` (
`id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`festival_id` int(10) UNSIGNED NOT NULL,
`user_id`     int(10) UNSIGNED NOT NULL,
`festivalcourse_id`     bigint(20) UNSIGNED NOT NULL,
`file`   mediumtext CHARACTER SET utf8mb4,
`desc`   mediumtext CHARACTER SET utf8mb4,
`score`  int(10) NULL DEFAULT NULL,
`price`  int(10) UNSIGNED NULL DEFAULT NULL,
`desc2`  text CHARACTER SET utf8mb4,
`status`    varchar(100) NULL DEFAULT NULL,
`type`      varchar(100) NULL DEFAULT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `festivalusers_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `festivalusers_course_id` FOREIGN KEY (`festivalcourse_id`) REFERENCES `festivalcourses` (`id`) ON UPDATE CASCADE,
CONSTRAINT `festivalusers_festival_id` FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `festivaluserallows` (
`id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`festival_id` int(10) UNSIGNED NOT NULL,
`user_id`     int(10) UNSIGNED NOT NULL,
`datecreated` timestamp DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `festivaluserallows_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `festivaluserallows_festival_id` FOREIGN KEY (`festival_id`) REFERENCES `festivals` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
