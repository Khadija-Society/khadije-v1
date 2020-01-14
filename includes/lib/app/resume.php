<?php
namespace lib\app;

/**
 * Class for resume.
 */
class resume
{
	public static $sort_field =
	[
		'id',
	];


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			return false;
		}

		$result = \lib\db\resume::get(['id' => $id, 'limit' => 1]);
		$temp = [];
		if(is_array($result))
		{
			$temp = self::ready($result);
		}
		return $temp;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function check($_id = null)
	{

		$company = \dash\app::request('company');
		if($company && mb_strlen($company) >= 100)
		{
			\dash\notif::error(T_("Please set company less than 100 character"), 'company');
			return false;
		}

		$type = \dash\app::request('type');
		if($type && mb_strlen($type) > 100)
		{
			\dash\notif::error(T_("Please set type less than 100 character"), 'type');
			return false;
		}

		$ceo = \dash\app::request('ceo');
		if($ceo && mb_strlen($ceo) > 100)
		{
			\dash\notif::error(T_("Please set ceo less than 100 character"), 'ceo');
			return false;
		}


		$startdate = \dash\app::request('startdate');
		if($startdate && mb_strlen($startdate) > 20)
		{
			\dash\notif::error(T_("Please set startdate less than 20 character"), 'startdate');
			return false;
		}

		$enddate = \dash\app::request('enddate');
		if($enddate && mb_strlen($enddate) > 20)
		{
			\dash\notif::error(T_("Please set enddate less than 20 character"), 'enddate');
			return false;
		}


		$desc = \dash\app::request('desc');

		$user_id = \dash\app::request('user_id');
		$user_id = \dash\coding::decode($user_id);

		if(!$user_id)
		{
			\dash\notif::error(T_("User not set"));
			return false;
		}

		if($user_id && !is_numeric($user_id))
		{
			\dash\notif::error(T_("Invalid user id"));
			return false;
		}

		$args              = [];
		$args['company']   = $company;
		$args['type']      = $type;
		$args['ceo']       = $ceo;
		$args['startdate'] = $startdate;
		$args['enddate']   = $enddate;
		$args['desc']      = $desc;
		$args['user_id']   = $user_id;

		return $args;

	}


	/**
	 * ready data of user to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'user_id':
					if(isset($value))
					{
						$result[$key] = \dash\coding::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}


	/**
	 * add new user
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args, $_option = [])
	{
		\dash\app::variable($_args);


		$default_option =
		[
			'debug'    => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);


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

		$args['creator'] = \dash\user::id();

		$return  = [];


		$resume = \lib\db\resume::insert($args);

		if(!$resume)
		{
			\dash\log::set('noWayToAddResume');
			\dash\notif::error(T_("No way to insert resume"));
			return false;
		}

		\dash\log::set('addResume');

		return $return;
	}


	public static function list($_string = null, $_args = [])
	{

		if(!\dash\user::id())
		{
			return false;
		}

		$default_args =
		[
			'order' => null,
			'sort'  => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$option = [];
		$option = array_merge($default_args, $_args);

		if($option['order'])
		{
			if(!in_array($option['order'], ['asc', 'desc']))
			{
				unset($option['order']);
			}
		}

		if($option['sort'])
		{
			if(!in_array($option['sort'], self::$sort_field))
			{
				unset($option['sort']);
			}
		}

		$field             = [];

		$result = \lib\db\resume::search($_string, $option, $field);

		$temp            = [];


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


	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args);

		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			\dash\notif::error(T_("Can not access to edit resume"), 'resume');
			return false;
		}

		if(!\dash\user::id())
		{
			return false;
		}

		// check args
		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}


		if(!\dash\app::isset_request('company')) unset($args['company']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('ceo')) unset($args['ceo']);
		if(!\dash\app::isset_request('startdate')) unset($args['startdate']);
		if(!\dash\app::isset_request('enddate')) unset($args['enddate']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);

		if(!empty($args))
		{
			\lib\db\resume::update($args, $id);
			\dash\log::set('editResume');
		}

		return true;
	}


	public static function remove($_id)
	{
		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			\dash\notif::error(T_("Can not access to remove this resume"));
			return false;
		}


		\lib\db\resume::delete($id);
		\dash\notif::ok(T_("Resume removed"));
		return true;
	}

}
?>