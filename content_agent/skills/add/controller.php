<?php
namespace content_agent\skills\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('aSkillsAdd');
	}
}
?>