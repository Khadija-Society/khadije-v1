<?php
namespace content_agent;


class controller
{
	public static function routing()
	{
		\dash\permission::access('contentAgent');
	}
}
?>
