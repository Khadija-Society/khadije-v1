<?php
namespace content_m\smsapp\addgroup;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>
