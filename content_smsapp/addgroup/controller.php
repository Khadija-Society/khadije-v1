<?php
namespace content_smsapp\addgroup;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>
