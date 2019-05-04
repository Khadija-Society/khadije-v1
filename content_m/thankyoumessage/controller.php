<?php
namespace content_m\thankyoumessage;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpSettingThankyouMessage');
	}
}
?>