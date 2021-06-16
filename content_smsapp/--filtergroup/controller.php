<?php
namespace content_smsapp\filtergroup;


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

		\content_smsapp\controller::do_not_tuch();

	}
}
?>
