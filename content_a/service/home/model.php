<?php
namespace content_a\service\home;

class model extends \content_a\main\model
{

	public function post_service()
	{
		if(\lib\utility::post('key') && \lib\utility::post('type') === 'cancel' && ctype_digit(\lib\utility::post('key')))
		{

			$key = \lib\utility::post('key');

			$check_valid_key = \lib\db\travels::get(['id' => $key, 'type' => 'family', 'user_id' => \lib\user::id(), 'limit' => 1]);

			if(!isset($check_valid_key['id']))
			{
				\lib\debug::error(T_("Invalid service id"));
				return false;
			}

			if(isset($check_valid_key['status']) && in_array($check_valid_key['status'], ['awaiting', 'draft']))
			{

				\lib\db\travels::update(['status' => 'cancel'], $key);

				\lib\debug::true(T_("Your service was canceled"));

				$this->redirector($this->url('full'));

			}
			else
			{
				\lib\debug::error(T_("Can not change this service status"));
				return false;
			}
		}
	}
}
?>
