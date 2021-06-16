<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class edit
{

	public static function archive_conversation($_mobile)
	{
		\lib\db\conversation\update::archive_conversation($_mobile, \lib\app\platoon\tools::get_index_locked());

		return true;

	}
}
?>