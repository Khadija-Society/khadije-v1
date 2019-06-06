UPDATE doyon SET doyon.subtitle = 'برنج خارجی' WHERE doyon.type = 'fetriye' and doyon.priceone = 24000;
UPDATE doyon SET doyon.subtitle = 'برنج ایرانی' WHERE doyon.type = 'fetriye' and doyon.priceone = 60000;
UPDATE doyon SET doyon.subtitle = 'گندم' WHERE doyon.type = 'fetriye' and doyon.priceone = 10000;
ALTER TABLE `doyon` ADD `donestatus`  enum('ok', 'cancel', 'awaiting') NULL DEFAULT 'awaiting';
ALTER TABLE `doyon` ADD `desc`  text CHARACTER SET utf8mb4 NULL;