<?php
namespace content_cp\thankyoumessage;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpSettingThankyouMessage');
	}
}
?>