<?php
namespace content_smsapp;

class controller
{
	public static function routing()
	{

		if(\dash\permission::supervisor() || \dash\user::detail('mobile') === '989127522690')
		{
			\dash\permission::access('smsAppSetting');
			// nothing
		}
		else
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter?referer='. \dash\url::pwd());
		}

	}


}
?>