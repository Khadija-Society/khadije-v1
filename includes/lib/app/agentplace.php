<?php
namespace lib\app;

/**
 * Class for place.
 */
class agentplace
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("place id not set"));
			return false;
		}

		$get = \lib\db\agentplace::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid place id"));
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
			\dash\notif::error(T_("Please fill the place title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the place title less than 150 character"), 'title');
			return false;
		}

		$check_duplicate = \lib\db\agentplace::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("Duplicate place title"), 'title');
				return false;
			}
		}




		$address = \dash\app::request('address');

		$capacity = \dash\app::request('capacity');
		if($capacity && !is_numeric($capacity))
		{
			\dash\notif::error(T_("Invalid capacity"));
			return false;
		}

		$city = \dash\app::request('city');
		if($city && !in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\dash\notif::error(T_("Invalid city"));
			return false;
		}


		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female', 'all']))
		{
			\dash\notif::error(T_("Invalid gender"));
			return false;
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of place"), 'status');
			return false;
		}

		$sort = \dash\app::request('sort');
		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Please set sort as a number"), 'sort');
			return false;
		}

		if($sort)
		{
			$sort = abs(intval($sort));
		}

		if($sort && $sort > 9999)
		{
			\dash\notif::error(T_("Sort is out of range"), 'sort');
			return false;
		}

		$desc = \dash\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) > 500)
		{
			\dash\notif::error(T_("Description must be less than 500 character"), 'desc');
			return false;
		}


		$subtitle = \dash\app::request('subtitle');

		if($subtitle && mb_strlen($subtitle) > 150)
		{
			\dash\notif::error(T_("Please fill the place subtitle less than 150 character"), 'subtitle');
			return false;
		}


		$file = \dash\app::request('file');

		$price = \dash\app::request('price');
		if($price && !is_numeric($price))
		{
			\dash\notif::error(T_("Please set price as a number"), 'price');
			return false;
		}



		$args               = [];
		$args['title']      = $title;
		$args['address']    = $address;
		$args['capacity']   = $capacity;
		$args['city']       = $city;
		$args['status']     = $status;
		$args['sort']       = $sort;
		$args['desc']       = $desc;
		$args['subtitle']   = $subtitle;
		$args['file']       = $file;
		$args['gender']     = $gender;

		return $args;
	}


	/**
	 * add new place
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
			$args['status']  = 'enable';
		}

		$place_id = \lib\db\agentplace::insert($args);

		if(!$place_id)
		{
			\dash\log::set('apiPlace:no:way:to:insertPlace');
			\dash\notif::error(T_("No way to insert place"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($place_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewPlace', ['code' => $place_id]);
			\dash\notif::ok(T_("Place successfuly added"));
		}

		return $return;
	}


		public static $sort_field =
	[
		'title',
		'subtitle',
		'activetime',
		'address',
		'desc',
		'file',
		'capacity',
		'city',
		'sort',
		'status',
	];

	public static function all_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	public static function active_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'status'     => 'enable',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	/**
	 * Gets the place.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The place.
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

		$result            = \lib\db\agentplace::search($_string, $_args);
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
	 * edit a place
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
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);

		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('file')) unset($args['file']);
		if(!\dash\app::isset_request('capacity')) unset($args['capacity']);
		if(!\dash\app::isset_request('city')) unset($args['city']);
		if(!\dash\app::isset_request('sort')) unset($args['sort']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('gender')) unset($args['gender']);

		if(!empty($args))
		{
			$update = \lib\db\agentplace::update($args, $id);
			\dash\log::set('editPlace', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of place to load in api
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