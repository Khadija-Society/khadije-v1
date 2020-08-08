<?php
namespace lib\app;

/**
 * Class for occasion.
 */
class occasion
{

	public static function get_active_list()
	{
		$date = date("Y-m-d");
		$result = \lib\db\occasion::get_active_list($date);
		if(!is_array($result))
		{
			$result = [];
		}

		$result = array_map(['self', 'ready'], $result);
		return $result;
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("occasion id not set"));
			return false;
		}

		$get = \lib\db\occasion::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{
		$title = \dash\app::request('title');
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the occasion title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the occasion title less than 150 character"), 'title');
			return false;
		}

		$check_duplicate = \lib\db\occasion::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("Duplicate occasion title"), 'title');
				return false;
			}
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft', 'registring', 'done', 'distribution', 'deleted']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$startdate = \dash\app::request('startdate');
		if($startdate && mb_strlen($startdate) > 100)
		{
			\dash\notif::error(T_("Invalid date"), 'startdate');
			return false;
		}

		$startdate = \dash\date::db($startdate);
		if($startdate === false)
		{
			\dash\notif::error(T_("Invalid date"), 'startdate');
			return false;
		}

		$startdate = \dash\date::force_gregorian($startdate);
		$startdate = \dash\date::db($startdate);


		$expiredate = \dash\app::request('expiredate');
		if($expiredate && mb_strlen($expiredate) > 100)
		{
			\dash\notif::error(T_("Invalid date"), 'expiredate');
			return false;
		}

		$expiredate = \dash\date::db($expiredate);
		if($expiredate === false)
		{
			\dash\notif::error(T_("Invalid date"), 'expiredate');
			return false;
		}

		$expiredate = \dash\date::force_gregorian($expiredate);
		$expiredate = \dash\date::db($expiredate);




		$type = \dash\app::request('type');
		if($type && !is_string($type))
		{
			\dash\notif::error(T_("Please set type as a string"), 'type');
			return false;
		}

		if(mb_strlen($type) > 200)
		{
			\dash\notif::error(T_("Type is out of range"), 'type');
			return false;
		}


		$subtitle = \dash\app::request('subtitle');
		if($subtitle && !is_string($subtitle))
		{
			\dash\notif::error(T_("Please set subtitle as a string"), 'subtitle');
			return false;
		}

		if(mb_strlen($subtitle) > 200)
		{
			\dash\notif::error(T_("Type is out of range"), 'subtitle');
			return false;
		}

		$desc = \dash\app::request('desc');

		$args               = [];

		$args['title']      = $title;
		$args['status']     = $status;
		$args['startdate']  = $startdate;
		$args['expiredate'] = $expiredate;
		$args['type']       = $type;
		$args['subtitle']   = $subtitle;
		$args['desc']       = $desc;

		return $args;
	}




	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check_detail($_id = null)
	{
		$title = \dash\app::request('title');
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the occasion title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the occasion title less than 150 character"), 'title');
			return false;
		}

		$desc = \dash\app::request('desc');

		$price = \dash\app::request('price');
		if($price && !is_numeric($price))
		{
			\dash\notif::error(T_("Please set price as a number"));
			return false;
		}

		if($price && floatval($price) > 999999999999)
		{
			\dash\notif::error(T_("Price out of range"));
			return false;
		}


		$args          = [];

		$args['title'] = $title;
		$args['desc']  = $desc;
		$args['price'] = $price;

		return $args;
	}


	public static function get_detail($_id)
	{
		$result = self::get($_id);

		if(!$result)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		$load = \lib\db\occasion::get_detail($id);
		return $load;


	}


	public static function remove_detail($_id)
	{

		$id = $_id;

		if($id && is_numeric($id))
		{
			$load = \lib\db\occasion::remove_detail($id);
			\dash\notif::ok(T_("Data removed"));
			return true;
		}



	}

	/**
	 * add new occasion
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("user not found"), 'user');
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
			$args['status']  = 'draft';
		}

		$args['datecreated'] = date("Y-m-d H:i:s");

		$occasion_id = \lib\db\occasion::insert($args);

		if(!$occasion_id)
		{
			\dash\log::set('apiOccasion:no:way:to:insertOccasion');
			\dash\notif::error(T_("No way to insert occasion"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($occasion_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewOccasion', ['code' => $occasion_id]);
			\dash\notif::ok(T_("Occasion successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'title',
		'subtitle',
		'id',

	];


	/**
	 * Gets the occasion.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The occasion.
	 */
	public static function list($_string = null, $_args = [])
	{
		// if(!\dash\user::id())
		// {
		// 	return false;
		// }

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

		$result            = \lib\db\occasion::search($_string, $_args);
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



	/**
	 * edit a occasion
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function add_detail($_args, $_id)
	{
		\dash\app::variable($_args);

		$result = self::get($_id);

		if(!$result)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		$args = self::check_detail($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$insert                           = $args;
		$insert['protection_occasion_id'] = $id;
		$insert['datecreated']            = date("Y-m-d H:i:s");

		$insert_id = \lib\db\occasion::insert_detail($insert);

		\dash\notif::ok(T_("Data saved"));
		return true;

	}

	/**
	 * edit a occasion
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
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
		if(!\dash\app::isset_request('startdate')) unset($args['startdate']);
		if(!\dash\app::isset_request('expiredate')) unset($args['expiredate']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);


		if(!empty($args))
		{
			$update = \lib\db\occasion::update($args, $id);
			\dash\log::set('editOccasion', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of occasion to load in api
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
					$result[$key] = \dash\coding::encode($value);
					break;

				case 'perm':
					if(is_string($value))
					{
						$result['perm'] = json_decode($value, true);
						if(is_array($result['perm']))
						{
							$result['perm'] = array_map(['\\dash\\coding', 'encode'], $result['perm']);
						}
					}
					else
					{
						$result[$key] = $value;
					}
					break;


				case 'file':
					if(!\dash\url::content())
					{
						if(!$value)
						{
							$value = \dash\app::static_logo_url();
						}
					}
					$result[$key] = $value;
					$result[$key] = $value;
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