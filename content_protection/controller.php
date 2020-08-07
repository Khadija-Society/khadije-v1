<?php
namespace content_protection;


class controller
{
	public static function routing()
	{
		\dash\permission::access('contentProtection');
	}
}
?>
