<?php
namespace lib\app;

/**
 * Class for servant.
 */
class servant
{
	public static $sort_field =
	[
		'title',
		'status',
	];


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

		$args['status'] = 'enable';
		$return = [];

		$servant_id = \lib\db\servant::insert($args);

		if(!$servant_id)
		{
			\dash\notif::error(T_("No way to insert data"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($servant_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewServant', ['code' => $servant_id]);
			\dash\notif::ok(T_("Servant successfuly added"));
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

		unset($args['user_id']);

		if(!empty($args))
		{
			$update = \lib\db\servant::update($args, $id);

			$title = isset($args['title']) ? $args['title'] : T_("Servant");

			\dash\log::set('editServant', ['code' => $id]);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":val successfully updated", ['val' => $title]));
			}
		}

		return \dash\engine\process::status();
	}


	public static function remove($_id)
	{
		$load = self::get($_id);
		if(!$load)
		{
			return false;
		}

		// \lib\db\servant::update(['status' => 'disable'] ,\dash\coding::decode($_id));
		\lib\db\servant::delete(\dash\coding::decode($_id));
		\dash\notif::ok(T_("Servant removed"));
		return true;
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("servant id not set"));
			return false;
		}

		$get = \lib\db\servant::get(['agent_servant.id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid servant id"));
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

		$result            = \lib\db\servant::search($_string, $_args);
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
		if(\dash\app::isset_request('member'))
		{
			$user_id = \dash\app::request('member');
			if(!$user_id)
			{
				\dash\notif::error(T_("Please select member"), 'member');
				return false;
			}

			$user_id = \dash\coding::decode($user_id);
			if(!$user_id)
			{
				\dash\notif::error(T_("Invalid user id"), 'member');
				return false;
			}

			$check_user = \dash\db\users::get_by_id($user_id);
			if(!isset($check_user['id']))
			{
				\dash\notif::error(T_("Member not found"), 'member');
				return false;
			}
		}
		else
		{
			$user_id = null;
		}


		$city = \dash\app::request('city');
		if(!$city)
		{
			\dash\notif::error(T_("Please choose city"), 'city');
			return false;
		}

		if($city && !in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\dash\notif::error(T_("Invalid city"));
			return false;
		}


		$job = \dash\app::request('job');
		if(!$job)
		{
			\dash\notif::error(T_("Please choose job"), 'job');
			return false;
		}

		if($job && !in_array($job, ['clergy', 'admin', 'missionary', 'servant']))
		{
			\dash\notif::error(T_("Invalid job"));
			return false;
		}



		$status = \dash\app::request('status');


		if($status && !in_array($status, ['enable', 'disable']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}



		if($user_id)
		{
			$check_duplicate = \lib\db\servant::get(['agent_servant.user_id' => $user_id, 'agent_servant.city' => $city, 'agent_servant.job' => $job, 'limit' => 1]);
			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					$code = \dash\coding::encode($check_duplicate['id']);
					$msg = T_("This servant is already exist in your list");
					$msg .= ' <a href="'. \dash\url::this(). '/edit?id='.$code. '">'. T_("Click here to edit it"). "</a>";
					\dash\notif::error($msg, 'member');
					return false;
				}
			}

		}

		$args            = [];
		$args['user_id'] = $user_id;
		$args['job']     = $job;
		$args['city']    = $city;
		$args['status']  = $status;

		return $args;
	}




	public static function ready($_data)
	{
		$result = \dash\app::ready($_data);

		return $result;
	}
}
?>