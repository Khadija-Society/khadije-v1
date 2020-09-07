<?php
namespace content_protection\agentoccasion\home;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonUserAdmin');
	}
}
?>