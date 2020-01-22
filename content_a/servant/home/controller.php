<?php
namespace content_a\servant\home;


class controller
{
	public static function routing()
	{
		if(!\dash\data::isAgentServant())
		{
			\dash\header::status(403);
		}

	}
}
?>