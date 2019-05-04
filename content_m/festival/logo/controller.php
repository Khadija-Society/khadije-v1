<?php
namespace content_m\festival\logo;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalEdit');

		\content_m\festival\controller::check_festival_id();

	}
}
?>
