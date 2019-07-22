<?php
namespace content_smsapp\report\groupby;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>