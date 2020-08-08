<?php
namespace content_a\protection\occasion;


class controller
{
	public static function routing()
	{
		\content_a\protection\main::check();

		$id = \dash\request::get('id');
		$load = \lib\app\occasion::get($id);
		if(!$load)
		{
			\dash\header::status(404);
		}

		\dash\data::occasionDetail($load);
	}
}
?>