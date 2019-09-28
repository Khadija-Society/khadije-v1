<?php
namespace content_mokeb;


class controller
{
	public static function routing()
	{
		\dash\redirect::to_login();
		\dash\permission::access('ContentMokeb');
	}
}
?>