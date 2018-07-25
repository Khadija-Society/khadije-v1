<?php
namespace content_fp\course\general;


class controller
{
	public static function routing()
	{
		\dash\permission::access('fpFestivalAdd');

		\content_fp\controller::check_festival_id();

	}
}
?>
