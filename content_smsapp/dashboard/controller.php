<?php
namespace content_smsapp\home;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>