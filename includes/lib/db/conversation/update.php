<?php
namespace lib\db\conversation;

/**
 * Class for sms.
 */
class update
{

	public static function archive_conversation($_mobile)
	{
		$date = date("Y-m-d H:i:s");
		$query =
		"
			UPDATE
				s_sms
			SET
				s_sms.group_id      = NULL,
				s_sms.answertext    = NULL,
				s_sms.sendstatus    = NULL,
				s_sms.dateanswer    = '$date',
				s_sms.receivestatus = 'skip'
			WHERE
				s_sms.fromnumber    = '$_mobile' AND
				s_sms.receivestatus = 'awaiting'

		";
		\dash\db::query($query);

		$query =
		"
			UPDATE
				s_sms
			SET
				s_sms.conversation_answered = 1
			WHERE
				s_sms.fromnumber = '$_mobile' AND
				s_sms.conversation_answered IS NULL

		";
		\dash\db::query($query);

		return true;

	}



	public static function stat()
	{

		$result = [];

		return $result;
		$result['all']      = floatval(\lib\db\conversation\get::count_all());
		$result['awaiting'] = floatval(\lib\db\conversation\get::count_awaiting());
		$result['answered'] = floatval(\lib\db\conversation\get::count_answered());

	}
}
?>