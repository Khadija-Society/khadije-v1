<?php
namespace content_agent\send\view;


class controller
{
	public static function routing()
	{
		$id     = \dash\request::get('id');
		$user_detail = \lib\app\send::get($id);

		if(!$user_detail)
		{
			\dash\header::status(404, T_("Detail not found"));
		}

		\dash\data::sendDetail($user_detail);

	}
}
?>