<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class get
{
	public static function current_mobile()
	{
		if(!\dash\request::get('mobile'))
		{
			return null;
		}

		$mobile = $_GET['mobile'];

		if(strpos($mobile, ' ') === 0)
		{
			$mobile = str_replace(' ', '+', $mobile);
		}

		if(preg_match("/^[\d\w\.\#\*\+\s]+$/", $mobile))
		{
			return $mobile;
		}

		return null;
	}


}
?>