<?php
namespace content_smsapp;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		if(\dash\permission::supervisor() || \dash\user::detail('mobile') === '989127522690')
		{
			// nothing
		}
		else
		{
			\dash\header::status(403);
		}

	}


}
?>