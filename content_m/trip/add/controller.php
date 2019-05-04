<?php
namespace content_m\trip\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpAddNewTrip');

	}
}
?>
