<?php
namespace lib\db\conversation;

/**
 * Class for sms.
 */
class update
{


	public static function multi_archive_conversation($_mobiles, $_platoon)
	{
		$_mobiles = implode("','", $_mobiles);
		$query =
		"
			UPDATE
				s_sms
			SET
				s_sms.conversation_answered = 1
			WHERE
				s_sms.fromnumber IN ('$_mobiles') AND
				s_sms.conversation_answered IS NULL AND
				s_sms.platoon = '$_platoon'

		";
		\dash\db::query($query);

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
				s_sms.fromnumber IN ('$_mobiles') AND
				s_sms.receivestatus = 'awaiting' AND
				s_sms.answertext IS NULL AND
				s_sms.platoon = '$_platoon'

		";
		\dash\db::query($query);

		\dash\db::query("UPDATE s_mobiles SET platoon_{$_platoon}_conversation_answered = 1 WHERE s_mobiles.mobile IN ('$_mobiles') ");



		return true;

	}

	public static function archive_conversation($_mobile, $_platoon)
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
				s_sms.platoon = '$_platoon' AND
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
				s_sms.platoon = '$_platoon' AND
				s_sms.conversation_answered IS NULL

		";
		\dash\db::query($query);

		\dash\db::query("UPDATE s_mobiles SET platoon_{$_platoon}_conversation_answered = 1 WHERE s_mobiles.mobile = '$_mobile' LIMIT 1");

		return true;

	}


	public static function record()
	{
		return \dash\db\config::public_update('s_sms', ...func_get_args());
	}


}
?>