<?php
namespace content_cp\smsapp\recommendgroup;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		$id   = \dash\request::get('id');
		$load = \lib\app\smsgroup::get($id);

		if(!$load)
		{
			\dash\header::status(404);
		}

		\dash\data::dataRow($load);
	}
}
?>