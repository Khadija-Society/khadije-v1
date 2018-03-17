<?php
namespace content_a\trip\home;

class model extends \content_a\main\model
{

	public function post_trip()
	{
		if(\lib\request::post('key') && \lib\request::post('type') === 'cancel' && ctype_digit(\lib\request::post('key')))
		{

			$key = \lib\request::post('key');

			$check_valid_key = \lib\db\travels::get(['id' => $key, 'type' => 'family', 'user_id' => \lib\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\lib\debug::error(T_("Invalid trip id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\travels::update(['status' => 'cancel'], $key);

				\lib\debug::true(T_("Your trip was canceled"));

				\lib\redirect::pwd();

			}
			else
			{
				\lib\debug::error(T_("Can not change this trip status"));
				return false;
			}
		}
	}
}
?>
