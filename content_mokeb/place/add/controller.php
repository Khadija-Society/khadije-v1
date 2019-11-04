<?php
namespace content_mokeb\place\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('ContentMokebAddPlace');
	}
}
?>