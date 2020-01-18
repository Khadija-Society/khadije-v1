<?php
namespace content_agent\send;


class load
{
	public static function load()
	{
		$id     = \dash\request::get('id');
		$send = \lib\app\send::get($id);

		if(!$send)
		{
			\dash\header::status(404, T_("Detail not found"));
		}

		\dash\data::dataRow($send);
	}
}
?>