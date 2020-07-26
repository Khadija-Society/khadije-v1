<?php
namespace content_m\festival\usercourse;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalUsersSignupEdit');

		\content_m\festival\controller::check_festival_id();

	}
}
?>
