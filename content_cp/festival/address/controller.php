<?php
namespace content_cp\festival\address;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalAdd');

		\content_cp\festival\controller::check_festival_id();

	}
}
?>
