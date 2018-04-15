<?php
namespace content_a\group\home;

class model
{

	public function post()
	{
		if(\dash\request::post('key') && \dash\request::post('type') === 'cancel' && ctype_digit(\dash\request::post('key')))
		{

			$key = \dash\request::post('key');

			$check_valid_key = \lib\db\travels::get(['id' => $key, 'type' => 'group', 'user_id' => \dash\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\dash\notif::error(T_("Invalid group id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\travels::update(['status' => 'cancel'], $key);

				\dash\notif::ok(T_("Your request was canceled"));

				\dash\redirect::pwd();

			}
			else
			{
				\dash\notif::error(T_("Can not change this group status"));
				return false;
			}
		}
	}
}
?>
