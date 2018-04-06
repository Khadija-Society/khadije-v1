<?php
namespace content_a\trip\home;

class model extends \content_a\main\model
{

	public function post_trip()
	{
		if(\dash\request::post('key') && \dash\request::post('type') === 'cancel' && ctype_digit(\dash\request::post('key')))
		{

			$key = \dash\request::post('key');

			$check_valid_key = \lib\db\travels::get(['id' => $key, 'type' => 'family', 'user_id' => \lib\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\lib\notif::error(T_("Invalid trip id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\travels::update(['status' => 'cancel'], $key);

				\lib\notif::ok(T_("Your trip was canceled"));

				\lib\redirect::pwd();

			}
			else
			{
				\lib\notif::error(T_("Can not change this trip status"));
				return false;
			}
		}
	}
}
?>
