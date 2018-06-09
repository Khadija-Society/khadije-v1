ALTER TABLE `needs` ADD `lang`       char(2) NULL  DEFAULT NULL;
UPDATE needs SET needs.lang = 'fa';
