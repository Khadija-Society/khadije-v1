ALTER TABLE `services` ADD `type`       varchar(50) NULL  DEFAULT NULL;
UPDATE services SET services.type = 'khadem' WHERE services.type IS NULL;
ALTER TABLE `needs` CHANGE `type` `type` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;