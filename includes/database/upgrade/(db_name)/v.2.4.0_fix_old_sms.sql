
UPDATE
	s_sms
SET
	s_sms.recommend_id = 7
WHERE
	s_sms.recommend_id is null and s_sms.group_id is null  and s_sms.sendstatus is null and (s_sms.text LIKE '%رمضان%')
