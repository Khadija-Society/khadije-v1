<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class edit
{

	public static function archive_conversation($_mobile)
	{
		\lib\db\conversation\update::archive_conversation($_mobile);

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