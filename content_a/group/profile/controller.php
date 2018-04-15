<?php
namespace content_a\group\profile;


class controller
{
	public static function ready()
	{
		\content_a\controller::check_trip_id('group');
	}
}
?>
