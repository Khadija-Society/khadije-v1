<?php
namespace lib\db\conversation;

class get
{

	public static function last_record_mobile($_mobile, $_platoon)
	{
		$query = "SELECT  * FROM s_sms WHERE s_sms.fromnumber = '$_mobile' AND s_sms.platoon = '$_platoon' ORDER BY s_sms.id DESC LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


}
?>