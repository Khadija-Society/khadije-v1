<?php
namespace content_smsapp\report\sendchart;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
	}
}
?>