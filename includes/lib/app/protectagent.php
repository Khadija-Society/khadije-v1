<?php
namespace lib\app;

/**
 * Class for protectagent.
 */
class protectagent
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("protectagent id not set"));
			return false;
		}

		$get = \lib\db\protectionagent::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid protectagent id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	private static $current_id = [];

	public static function get_current_id($_key = 'id')
	{
		if(empty(self::$current_id))
		{
			if(!\dash\user::id())
			{
				return false;
			}

			$load_args =
			[
				'user_id' => \dash\user::id(),
				'limit'   => 1,
			];

			$load = \lib\db\protectionagent::get($load_args);

			self::$current_id = $load;
		}


		if(isset(self::$current_id[$_key]))
		{
			return self::$current_id[$_key];
		}

		return null;
	}

	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{
		$args = [];


		$title = \dash\app::request('title');
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the protectagent title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the protectagent title less than 150 character"), 'title');
			return false;
		}

		$mobile = \dash\app::request('mobile');
		$mobile = \dash\utility\filter::mobile($mobile);

		if(!$mobile)
		{
			\dash\notif::error(T_("Please enter mobile"));
			return false;
		}

		$check_mobile = \dash\db\users::get_by_mobile($mobile);
		if(isset($check_mobile['id']))
		{
			$args['user_id'] = $check_mobile['id'];
		}
		else
		{
			$load_user = \dash\db\users::signup(['mobile' => $mobile, 'displayname' => substr($title, 0, 99)]);
			if($load_user)
			{
				$args['user_id'] = $load_user;
			}
		}

		$check_duplicate = \lib\db\protectionagent::get(['user_id' => $args['user_id'], 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("This user already add to your agent list"), 'mobile');
				return false;
			}
		}

		$type = \dash\app::request('type');
		if($type && mb_strlen($type) > 150)
		{
			\dash\notif::error(T_("Please fill the protectagent type less than 150 character"), 'type');
			return false;
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft', 'pending', 'enable', 'block', 'deleted']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$desc = \dash\app::request('desc');
		$address = \dash\app::request('address');

		$bankaccountnumber = \dash\app::request('bankaccountnumber');
		if($bankaccountnumber && mb_strlen($bankaccountnumber) > 150)
		{
			$bankaccountnumber = substr($bankaccountnumber, 0, 150);
		}

		$bankshaba = \dash\app::request('bankshaba');
		if($bankshaba && mb_strlen($bankshaba) > 150)
		{
			$bankshaba = substr($bankshaba, 0, 150);
		}

		$bankhesab = \dash\app::request('bankhesab');
		if($bankhesab && mb_strlen($bankhesab) > 150)
		{
			$bankhesab = substr($bankhesab, 0, 150);
		}


		$bankcart = \dash\app::request('bankcart');
		if($bankcart && mb_strlen($bankcart) > 150)
		{
			$bankcart = substr($bankcart, 0, 150);
		}


		$bankname = \dash\app::request('bankname');
		if($bankname && mb_strlen($bankname) > 150)
		{
			$bankname = substr($bankname, 0, 150);
		}

		$bankownername = \dash\app::request('bankownername');
		if($bankownername && mb_strlen($bankownername) > 150)
		{
			$bankownername = substr($bankownername, 0, 150);
		}

		$city = \dash\app::request('city');
		if($city && !\dash\utility\location\cites::check($city))
		{
			\dash\notif::error(T_("Invalid city"), 'city');
			return false;
		}


		$province = null;
		if($city)
		{
			$province = \dash\utility\location\cites::get($city, 'province', 'province');
			if(!\dash\utility\location\provinces::check($province))
			{
				$province = null;
			}
		}

		$args['title']             = $title;
		$args['type']              = $type;
		$args['status']            = $status;
		$args['desc']              = $desc;
		$args['address']           = $address;
		$args['bankaccountnumber'] = $bankaccountnumber;
		$args['bankshaba']         = $bankshaba;
		$args['bankhesab']         = $bankhesab;
		$args['bankcart']          = $bankcart;
		$args['bankname']          = $bankname;
		$args['bankownername']     = $bankownername;
		$args['province']          = $province;
		$args['city']              = $city;


		return $args;
	}





	/**
	 * add new protectagent
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

		$protectagent_id = \lib\db\protectionagent::insert($args);

		if(!$protectagent_id)
		{
			\dash\log::set('apiprotectAgent:no:way:to:insertprotectAgent');
			\dash\notif::error(T_("No way to insert protectagent"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($protectagent_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewprotectAgent', ['code' => $protectagent_id]);
			\dash\notif::ok(T_("protectAgent successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'title',
		'type',
		'id',

	];


	/**
	 * Gets the protectagent.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The protectagent.
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

		$result            = \lib\db\protectionagent::search($_string, $_args);

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
	 * edit a protectagent
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
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('bankaccountnumber')) unset($args['bankaccountnumber']);
		if(!\dash\app::isset_request('bankshaba')) unset($args['bankshaba']);
		if(!\dash\app::isset_request('bankhesab')) unset($args['bankhesab']);
		if(!\dash\app::isset_request('bankcart')) unset($args['bankcart']);
		if(!\dash\app::isset_request('bankname')) unset($args['bankname']);
		if(!\dash\app::isset_request('bankownername')) unset($args['bankownername']);
		if(!\dash\app::isset_request('city')) unset($args['province']);
		if(!\dash\app::isset_request('city')) unset($args['city']);


		if(!empty($args))
		{
			$update = \lib\db\protectionagent::update($args, $id);
			\dash\log::set('editprotectAgent', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of protectagent to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		$result['location_string'] = [];
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

				case 'province':
					$result[$key] = $value;
					$result['province_name'] = \dash\utility\location\provinces::get_localname($value);
					$result['location_string'][2] = $result['province_name'];
					break;

				case 'city':
					$result[$key] = $value;
					$result['city_name'] = \dash\utility\location\cites::get_localname($value);
					$result['location_string'][3] = $result['city_name'];
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

		$result['location_string'] = implode(' - ', $result['location_string']);

		return $result;
	}

}
?>