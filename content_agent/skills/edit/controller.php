<?php
namespace content_agent\skills\edit;


class controller
{
	public static function routing()
	{
		\dash\permission::access('aSkillsEdit');
	}
}
?>