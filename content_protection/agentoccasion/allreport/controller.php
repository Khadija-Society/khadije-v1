<?php
namespace content_protection\agentoccasion\allreport;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonReport');
	}
}
?>