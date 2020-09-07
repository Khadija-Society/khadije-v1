<?php
namespace content_protection\allusers;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonUserAdmin');
	}
}
?>