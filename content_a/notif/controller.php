<?php
namespace content_a\notif;


class controller
{
	public static function routing()
	{
		if(\dash\permission::supervisor() || \dash\user::detail('mobile') === '989195191378')
		{

		}
		else
		{
			\dash\header::status(403);
		}

	}
}
?>