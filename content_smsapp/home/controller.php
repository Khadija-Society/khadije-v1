<?php
namespace content_smsapp\home;

class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');
		\dash\redirect::to(\dash\url::here(). '/conversation'. \dash\data::platoonGet());
	}
}
?>