<?php
namespace content_cp\festival\social;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalEdit');

		\content_cp\festival\controller::check_festival_id();

	}
}
?>
