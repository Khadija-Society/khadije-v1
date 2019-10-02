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

		$mokebkey = \dash\header::get('mokebkey');

		if(!trim($mokebkey))
		{
			\content_api\v6::no(400, T_("Appkey not set"));
		}

		if($mokebkey === '078c6e1158437f0b3ba0f52e705ec698')
		{
			// no thing
		}
		else
		{
			\content_api\v6::no(400, T_("Invalid app key"));
		}

		$input = self::get_input();

		if(isset($input['users']) && is_array($input['users']) && $input['users'])
		{
			self::sync_users($input['users']);
		}
		if(isset($input['forceexit']) && is_array($input['forceexit']) && $input['forceexit'])
		{
			self::setforceexit($input['forceexit']);
		}

		$all_place = \lib\db\mokebusers::all_place();
		$all_users = \lib\db\mokebusers::all_user();

		$result = [];

		$result['setforceexit'] = self::forceexit();
		$result['all_users'] = $all_users;
		$result['all_place'] = $all_place;

		\content_api\v6::bye($result);
	}


	private static function setforceexit($_data)
	{
		$q = [];
		foreach ($_data as $key => $value)
		{
			if(isset($value['id']))
			{
				$temp = $value;
				unset($temp['id']);
				unset($temp['forceexit']);
				$temp['forceexit'] = 1;
				$set = \dash\db\config::make_set($temp);
				if($set)
				{
					$q[] = " UPDATE mokebusers SET $set WHERE mokebusers.id = '$value[id]' LIMIT 1 ";
				}

			}
		}

		if(!empty($q))
		{
			$q = implode(';', $q);
			\dash\db::query($q, true, ['multi_query' => true]);
		}
	}


	private static function forceexit()
	{

		$query =
		"
			SELECT
				mokebusers.id,
				mokebusers.forceexit,
				mokebusers.forceexitdate,
				mokebusers.oldposition,
				mokebusers.position
			FROM mokebusers
			WHERE
				mokebusers.forceexit = 1
		";
		$result = \dash\db::get($query);
		return $result;

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