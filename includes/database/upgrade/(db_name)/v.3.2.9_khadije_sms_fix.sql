UPDATE s_mobiles SET s_mobiles.platoon_1_conversation_answered = 1 WHERE s_mobiles.platoon_1 = 1 AND s_mobiles.id NOT IN (SELECT s_sms.mobile_id FROM s_sms WHERE s_sms.platoon = '1' AND s_sms.conversation_answered IS NULL);
UPDATE s_mobiles SET s_mobiles.platoon_2_conversation_answered = 1 WHERE s_mobiles.platoon_2 = 1 AND s_mobiles.id NOT IN (SELECT s_sms.mobile_id FROM s_sms WHERE s_sms.platoon = '2' AND s_sms.conversation_answered IS NULL);

