<?php
namespace content_smsapp\report\countsmsday;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>