<?php
namespace content_api\v6\smsapp;


class status
{
	public static function set()
	{
		$status = \dash\request::post('status');
		$status = mb_strtolower($status);
		if($status === 'true')
		{
			\content_api\v6\smsapp\controller::status(true);
			\dash\notif::ok(T_("The system power on"));
			return true;
		}
		elseif($status === 'false')
		{
			\content_api\v6\smsapp\controller::status(false);
			\dash\notif::ok(T_("The system set off"));
			return true;
		}
		else
		{
			\dash\notif::ok(T_("Invalid status"));
			return true;
		}
	}
}
?>