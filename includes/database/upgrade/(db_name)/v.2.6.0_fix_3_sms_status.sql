UPDATE s_sms SET s_sms.receivestatus = 'answerready'  WHERE s_sms.sendstatus = 'send' and s_sms.receivestatus != 'answerready';