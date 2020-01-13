<?php
namespace content_agent\servant\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('aServantAdd');
	}
}
?>