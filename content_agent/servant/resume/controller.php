<?php
namespace content_agent\servant\profile;


class controller
{
	public static function routing()
	{
		$user_id     = \dash\request::get('user');
		$user_detail = \dash\app\user::get($user_id);

		if(!$user_detail)
		{
			\dash\header::status(404, T_("User not found"));
		}

		\dash\data::userDetail($user_detail);

	}
}
?>