<?php
namespace content_a\service\home;

class model extends \content_a\main\model
{

	public function post_service()
	{
		if(\lib\request::post('key') && \lib\request::post('type') === 'cancel' && ctype_digit(\lib\request::post('key')))
		{

			$key = \lib\request::post('key');

			$check_valid_key = \lib\db\services::get(['id' => $key,  'user_id' => \lib\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\lib\notif::error(T_("Invalid service id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\services::update(['status' => 'cancel'], $key);

				\lib\notif::true(T_("Your service was canceled"));

				\lib\redirect::pwd();

			}
			else
			{
				\lib\notif::error(T_("Can not change this service status"));
				return false;
			}
		}
	}
}
?>
