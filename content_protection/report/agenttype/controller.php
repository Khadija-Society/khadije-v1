<?php
namespace content_protection\report\agenttype;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonReport');

	}
}
?>