<?php
namespace content_agent\send\assessment;


class controller
{
	public static function routing()
	{
		$id     = \dash\request::get('id');
		$send = \lib\app\send::get($id);

		if(!$send)
		{
			\dash\header::status(404, T_("Detail not found"));
		}

		\dash\data::sendDetail($send);
	}
}
?>