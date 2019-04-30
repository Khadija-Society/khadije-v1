<?php
namespace content_cp\smsapp\home;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>