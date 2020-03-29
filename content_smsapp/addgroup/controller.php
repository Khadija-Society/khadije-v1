<?php
namespace content_smsapp\addgroup;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		\content_smsapp\controller::do_not_tuch();

	}
}
?>
