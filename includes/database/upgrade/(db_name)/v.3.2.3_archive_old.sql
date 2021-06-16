UPDATE s_sms SET s_sms.conversation_answered = 1 WHERE  s_sms.answertext IS NOT NULL;
