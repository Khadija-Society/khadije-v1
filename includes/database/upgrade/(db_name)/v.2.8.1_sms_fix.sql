UPDATE  `s_sms` set
s_sms.sendstatus = null,
s_sms.answertext = null,
s_sms.dateanswer = null,
s_sms.receivestatus = 'awaiting',
s_sms.group_id = null
WHERE s_sms.sendstatus = 'awaiting'