<?php
namespace content_api\v6\mokeb;


class controller
{
	public static function routing()
	{
		if(!\dash\request::is('post'))
		{
			\content_api\v6::no(404);
		}

		$input = self::get_input();

		if(isset($input['users']) && is_array($input['users']) && $input['users'])
		{
			self::sync_users($input['users']);
		}

		$all_users = \lib\db\mokebusers::all_user();
		$all_place = \lib\db\mokebusers::all_place();

		$result = [];
		$result['all_users'] = $all_users;
		$result['all_place'] = $all_place;

		\content_api\v6::bye($result);
	}


	private static function sync_users($_data)
	{
		$inset = [];
		$server_ids = \lib\db\mokebusers::get_ids();
		foreach ($_data as $key => $value)
		{
			if(isset($value['id']))
			{
				if(!in_array($value['id'], $server_ids))
				{
					$inset[] = $value;
				}
			}
		}

		if(!empty($inset))
		{
			\lib\db\mokebusers::multi_insert($inset);
		}
	}


	private static function get_input()
	{
		$get_input = @file_get_contents('php://input');
		if(!$get_input || !is_string($get_input))
		{
			\dash\notif::error(T_("No input was send!"));
			return false;
		}

		$get_input = json_decode($get_input, true);
		if(!is_array($get_input))
		{
			\dash\notif::error(T_("Invalid input syntax"));
			return false;
		}

		if(!$get_input)
		{
			\dash\notif::error(T_("Empty input"));
			return false;
		}

		return $get_input;

	}
}
?>