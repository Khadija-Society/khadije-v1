<?php
namespace content_protection\protectagent\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonAgentAdmin');
	}
}
?>