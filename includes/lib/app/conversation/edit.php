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
}
?>