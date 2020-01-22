<?php
namespace content_a\servant;


class model
{
	public static function post()
	{

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Note saved"));
			\dash\redirect::pwd();
		}
	}
}
?>