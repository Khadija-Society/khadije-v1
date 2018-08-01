<?php
namespace content_cp\festival\message;


class controller
{
	public static function routing()
	{
		\dash\permission::access('fpFestivalAdd');

		\content_cp\controller::check_festival_id();

	}
}
?>
