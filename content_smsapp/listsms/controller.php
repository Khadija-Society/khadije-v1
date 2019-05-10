<?php
namespace content_smsapp\listsms;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		$child = \dash\url::child();

		if($child && \dash\utility\filter::mobile($child))
		{
			\dash\open::get();
			\dash\open::post();
		}


	}
}
?>
