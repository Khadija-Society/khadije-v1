<?php
namespace content_smsapp;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

	}


}
?>