<?php
namespace content_cp\smsapp\addgroup;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>
