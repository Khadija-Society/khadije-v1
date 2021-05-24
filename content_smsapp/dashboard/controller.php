<?php
namespace content_smsapp\dashboard;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>