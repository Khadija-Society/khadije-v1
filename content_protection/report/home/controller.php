<?php
namespace content_protection\report\home;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonReport');
	}
}
?>