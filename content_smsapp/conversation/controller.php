<?php
namespace content_smsapp\conversation;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

	}
}
?>