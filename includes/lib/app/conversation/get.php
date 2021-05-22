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

		if(strpos($mobile, ' ') !== false)
		{
			$mobile = str_replace(' ', '+', $mobile);
		}

		if(preg_match("/^[\d\w\.\#\*\+]+$/", $mobile))
		{
			return $mobile;
		}

		return null;
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