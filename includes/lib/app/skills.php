<?php
namespace lib\app;

/**
 * Class for skills.
 */
class skills
{
	public static $sort_field =
	[
		'title',
		'status',
	];
	public static function remove_user_skills($_skills)
	{
		if(!$_skills || !is_numeric($_skills))
		{
			\dash\notif::error(T_("Please choose skills"), 'skills');
			return false;
		}

		\lib\db\userskills::delete($_skills);

		\dash\notif::ok(T_("Data removed"));

		return true;
	}


	public static function add_user_skills($_user_code, $_skills, $_rate, $_desc)
	{
		if(!$_skills)
		{
			\dash\notif::error(T_("Please choose skills"), 'skills');
			return false;
		}

		$user_id = \dash\coding::decode($_user_code);
		if(!$user_id)
		{
			\dash\notif::error(T_("User not found"));
			return false;
		}

		$skills_id = \dash\coding::decode($_skills);
		if($skills_id)
		{
			$load_skills = \lib\db\skills::get(['id' => $skills_id, 'limit' => 1]);

			if(!$load_skills)
			{
				\dash\notif::error(T_("Please choose a valid skills"), 'skills');
				return false;
			}
		}
		else
		{
			$add_skills = self::add(['title' => $_skills]);
			if(!$add_skills || !isset($add_skills['id_raw']))
			{
				return false;
			}

			$skills_id = $add_skills['id_raw'];
		}

		$load_user = \dash\db\users::get_by_id($user_id);
		if(!isset($load_user['id']))
		{
			\dash\notif::error(T_("User not found"));
			return false;
		}
		$check_duplicate = \lib\db\userskills::get(['user_id' => $user_id, 'skills_id' => $skills_id, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			\dash\notif::error(T_("This skills already added to this user"), 'skills');
			return false;
		}

		if($_rate && !is_numeric($_rate))
		{
			$_rate = null;
		}

		if(intval($_rate) > 5)
		{
			$_rate = 5;
		}

		if(intval($_rate) < 0)
		{
			$_rate = 0;
		}

		\lib\db\userskills::insert(['user_id' => $user_id, 'skills_id' => $skills_id, 'desc' => $_desc, 'rate' => $_rate]);

		\dash\notif::ok(T_("Data saved"));

		return true;
	}


	public static function add($_args = [])
	{
		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check();

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$return = [];

		if(!$args['status'])
		{
			$args['status']  = 'enable';
		}


		$skills_id = \lib\db\skills::insert($args);

		if(!$skills_id)
		{
			\dash\notif::error(T_("No way to insert data"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($skills_id);
		$return['id_raw'] = $skills_id;

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewSkills', ['code' => $skills_id]);
			\dash\notif::ok(T_("Skills successfuly added"));
		}

		return $return;
	}


	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args);

		$result = self::get($_id);

		if(!$result)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('status')) unset($args['status']);

		if(!empty($args))
		{
			$update = \lib\db\skills::update($args, $id);

			$title = isset($args['title']) ? $args['title'] : T_("Skills");

			\dash\log::set('editSkills', ['code' => $id]);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":val successfully updated", ['val' => $title]));
			}
		}

		return \dash\engine\process::status();
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("skills id not set"));
			return false;
		}

		$get = \lib\db\skills::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid skills id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	public static function list($_string = null, $_args = [])
	{
		if(!\dash\user::id())
		{
			return false;
		}

		$default_meta =
		[
			'sort'  => null,
			'order' => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_meta, $_args);

		if($_args['sort'] && !in_array($_args['sort'], self::$sort_field))
		{
			$_args['sort'] = null;
		}

		$result            = \lib\db\skills::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = self::ready($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}


	private static function check($_id = null)
	{
		$title = \dash\app::request('title');
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 300)
		{
			\dash\notif::error(T_("Please fill the title less than 300 character"), 'title');
			return false;
		}


		$check_duplicate = \lib\db\skills::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				$code = \dash\coding::encode($check_duplicate['id']);
				$msg = T_("This title is already exist in your list");
				$msg .= ' <a href="'. \dash\url::this(). '/edit?id='.$code. '">'. T_("Click here to edit it"). "</a>";
				\dash\notif::error($msg, 'title');
				return false;
			}
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable','disable','suspend','broken']))
		{
			\dash\notif::error(T_("Invalid status"), 'status');
			return false;
		}

		$args           = [];
		$args['title']  = $title;
		$args['status'] = $status;
		return $args;
	}




	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
					if(isset($value))
					{
						$result[$key] = \dash\coding::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
					break;

				case 'setting':
					if($value)
					{
						$result[$key] = json_decode($value, true);
					}
					else
					{
						$result[$key] = $value;
					}
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}
}
?>