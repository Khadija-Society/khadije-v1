<?php
namespace content_protection\occasion\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonOccasionAdmin');
	}
}
?>