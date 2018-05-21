<?php
namespace content_a\advice\home;

class model
{

	public static function post()
	{
		if(\dash\request::post('key') && \dash\request::post('type') === 'cancel' && ctype_digit(\dash\request::post('key')))
		{
			$key = \dash\request::post('key');

			$check_valid_key = \lib\db\services::get(['id' => $key,  'user_id' => \dash\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\dash\notif::error(T_("Invalid service id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\services::update(['status' => 'cancel'], $key);

				\dash\notif::ok(T_("Your service was canceled"));

				\dash\redirect::pwd();

			}
			else
			{
				\dash\notif::error(T_("Can not change this service status"));
				return false;
			}
		}
	}
}
?>
