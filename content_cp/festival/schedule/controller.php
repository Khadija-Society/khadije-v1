<?php
namespace content_cp\festival\schedule;


class controller
{
	public static function routing()
	{
		\dash\permission::access('fpFestivalAdd');

		\content_cp\festival\controller::check_festival_id();

	}
}
?>