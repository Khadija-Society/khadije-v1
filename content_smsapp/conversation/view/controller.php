<?php
namespace content_smsapp\conversation\view;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		\dash\data::myMobile(\lib\app\conversation\get::current_mobile());
	}
}
?>
