<?php
namespace content_mokeb\home;


class controller
{
	public static function routing()
	{
		\dash\permission::access('ContentMokeb');
	}
}
?>