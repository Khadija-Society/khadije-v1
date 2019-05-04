<?php
namespace content_m\festival\address;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalAdd');

		\content_m\festival\controller::check_festival_id();

	}
}
?>
