<?php
namespace content_cp\disalltrip;


class model
{
	public static function post()
	{
		\dash\permission::access('cpDisableAllTrip');

		$city = \dash\request::post('city');

		if($city && in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\lib\db\travels::disable_all_trip($city);
			\dash\notif::ok(T_("All trip was set on expire status"));
			\dash\redirect::pwd();
		}
		else
		{
			\dash\notif::error(T_("Dont!"));
			return false;
		}
	}
}
?>
