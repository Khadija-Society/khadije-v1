
UPDATE s_mobiles SET s_mobiles.platoon_1_lastsmstime = (SELECT UNIX_TIMESTAMP(s_sms.datecreated) FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_1 = 1;
UPDATE s_mobiles SET s_mobiles.platoon_2_lastsmstime = (SELECT UNIX_TIMESTAMP(s_sms.datecreated) FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.fromnumber = s_mobiles.mobile ORDER BY s_sms.id DESC LIMIT 1) WHERE s_mobiles.platoon_2 = 1;
