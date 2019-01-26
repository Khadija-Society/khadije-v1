<?php
namespace content_cp\trip\add;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpAddNewTrip');

	}
}
?>
