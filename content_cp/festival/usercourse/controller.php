<?php
namespace content_cp\festival\social;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpFestivalUsersSignupEdit');

		\content_cp\festival\controller::check_festival_id();

	}
}
?>