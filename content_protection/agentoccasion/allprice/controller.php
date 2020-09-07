<?php
namespace content_protection\agentoccasion\allprice;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonPriceAdmin');
	}
}
?>