UPDATE s_sms SET s_sms.receivestatus = 'answerready' where s_sms.receivestatus != 'answerready' and s_sms.sendstatus = 'send';