<?php
namespace lib\app;

class travel
{
	public static $sort_field =
	[
		'id',
		'place',
		'countpeople',
		'type',
		'status',
		'startdate',
		'enddate',
		'countpartner',
	];


	public static $cityplace_cat = 'city_place';


	public static function cityList($_trans = false)
	{
		$city =
		[
			($_trans ? T_("Karbala") : "karbala"),
			($_trans ? T_("Mashhad") : "mashhad"),
			($_trans ? T_("Qom") 	 : "qom"),
		];

		return $city;
	}



	public static function group_active_city()
	{
		$get_detail =
		[
			'cat'    => 'group_city',
			'status' => 'enable',
		];

		$get = \dash\db\options::get($get_detail);

		$cityList = [];

		if(is_array($get))
		{
			$temp = array_column($get, 'value');
			foreach ($temp as $key => $value)
			{
				$cityList[$value] = T_($value);
			}
		}

		return $cityList;
	}


	public static function active_city($_all = false)
	{
		if($_all)
		{
			$get_detail =
			[
				'cat'    => 'trip_city',
			];
		}
		else
		{

			$get_detail =
			[
				'cat'    => 'trip_city',
				'status' => 'enable',
			];
		}

		$get = \dash\db\options::get($get_detail);

		$cityList = [];

		if(is_array($get))
		{
			$temp = array_column($get, 'value');
			foreach ($temp as $key => $value)
			{
				$cityList[$value] = T_($value);
			}
		}

		return $cityList;
	}


	public static function trip_get_terms($_type, $_city)
	{
		$get =
		[
			'cat'   => 'trip_terms',
			'key'   => $_type. '_'. $_city,
			'limit' => 1
		];

		$load = \dash\db\options::get($get);
		if(isset($load['meta']))
		{
			return $load['meta'];
		}
		return null;

	}


	public static function trip_set_terms($_type, $_city, $_text)
	{
		$get =
		[
			'cat'   => 'trip_terms',
			'key'   => $_type. '_'. $_city,
			'limit' => 1
		];

		$_text = \dash\safe::safe($_text, 'raw');

		$load = \dash\db\options::get($get);
		if(isset($load['id']))
		{
			\dash\db\options::update(['meta' => $_text], $load['id']);
		}
		else
		{
			$set =
			[
				'cat'  => 'trip_terms',
				'key'  => $_type. '_'. $_city,
				'meta' => $_text,
			];
			\dash\db\options::insert($set);
		}

	}


	public static function save_option_setting($_cat, $_key, $_value, $_action)
	{
		if(!$_action || $_action == '')
		{
			$_action = false;
		}
		else
		{
			$_action = true;
		}

		$get_detail =
		[
			'cat'   => $_cat,
			'key'   => $_key,
			'limit' => 1,
		];

		$get = \dash\db\options::get($get_detail);

		if(isset($get['id']))
		{
			$update = true;
		}
		else
		{
			$update = false;
		}

		if($_action || $_action === '0')
		{
			if($update)
			{
				\dash\db\options::update(['status' => 'enable', 'value' => $_value], $get['id']);
			}
			else
			{
				$insert_new =
				[
					'cat'    => $_cat,
					'key'    => $_key,
					'value'  => $_value,
					'status' => 'enable',
				];
				\dash\db\options::insert($insert_new);
			}
		}
		else
		{
			if($update)
			{
				\dash\db\options::update(['status' => 'disable', 'value' => $_value], $get['id']);
			}
			else
			{
				$insert_new =
				[
					'cat'    => $_cat,
					'key'    => $_key,
					'value'  => $_value,
					'status' => 'disable',
				];
				\dash\db\options::insert($insert_new);
			}
		}
	}


	public static function city_signup_setting($_city, $_action)
	{

		if(!in_array($_city, self::cityList()))
		{
			\dash\notif::error(T_("Invalid city"));
			return false;
		}

		self::save_option_setting('trip_city', 'trip_city_'. $_city, $_city, $_action);

	}


	public static function trip_master_active($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'trip_settings', 'key' => 'trip_master_active', 'value' => 'trip_master_active', 'limit' => 1]);
			if(isset($get['status']) && $get['status'] === 'enable')
			{
				return true;
			}
			return false;
		}
		else
		{
			self::save_option_setting('trip_settings', 'trip_master_active', 'trip_master_active', $_action);
		}
	}


	public static function trip_count_partner($_action = 'get', $_city = null)
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'trip_settings', 'key' => 'trip_count_partner'. $_city, 'limit' => 1]);
			if(isset($get['value']))
			{
				return $get['value'];
			}
			return false;
		}
		else
		{
			self::save_option_setting('trip_settings', 'trip_count_partner'. $_city, $_action, $_action);
		}
	}

	public static function trip_max_awaiting($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'trip_settings', 'key' => 'trip_max_awaiting', 'limit' => 1]);
			if(isset($get['value']))
			{
				return $get['value'];
			}
			return false;
		}
		else
		{
			self::save_option_setting('trip_settings', 'trip_max_awaiting', $_action, $_action);
		}
	}

	//----------------------------------------------------------------------------------------------------

	public static function group_city_signup_setting($_city, $_action)
	{

		if(!in_array($_city, self::cityList()))
		{
			\dash\notif::error(T_("Invalid city"));
			return false;
		}

		self::save_option_setting('group_city', 'group_city_'. $_city, $_city, $_action);

	}


	public static function group_master_active($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'group_settings', 'key' => 'group_master_active', 'value' => 'group_master_active', 'limit' => 1]);
			if(isset($get['status']) && $get['status'] === 'enable')
			{
				return true;
			}
			return false;
		}
		else
		{
			self::save_option_setting('group_settings', 'group_master_active', 'group_master_active', $_action);
		}
	}


	public static function group_count_partner_min($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'group_settings', 'key' => 'group_count_partner_min', 'limit' => 1]);
			if(isset($get['value']) && $get['value'] )
			{
				return $get['value'];
			}
			return false;
		}
		else
		{
			self::save_option_setting('group_settings', 'group_count_partner_min', $_action, $_action);
		}
	}

	public static function group_count_partner_max($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'group_settings', 'key' => 'group_count_partner_max', 'limit' => 1]);
			if(isset($get['value']) && $get['value'] )
			{
				return $get['value'];
			}
			return false;
		}
		else
		{
			self::save_option_setting('group_settings', 'group_count_partner_max', $_action, $_action);
		}
	}


	public static function group_max_awaiting($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'group_settings', 'key' => 'group_max_awaiting', 'limit' => 1]);
			if(isset($get['value']) && $get['value'])
			{
				return $get['value'];
			}
			return false;
		}
		else
		{
			self::save_option_setting('group_settings', 'group_max_awaiting', $_action, $_action);
		}
	}


	public static function group_getdate($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'group_settings', 'key' => 'group_getdate', 'value' => 'group_getdate', 'limit' => 1]);
			if(isset($get['status']) && $get['status'] === 'enable')
			{
				return true;
			}
			return false;
		}
		else
		{
			self::save_option_setting('group_settings', 'group_getdate', 'group_getdate', $_action);
		}
	}



	//----------------------------------------------------------------------------------------------------

	public static function trip_getdate($_action = 'get')
	{
		if($_action === 'get')
		{
			$get = \dash\db\options::get(['cat' => 'trip_settings', 'key' => 'trip_getdate', 'value' => 'trip_getdate', 'limit' => 1]);
			if(isset($get['status']) && $get['status'] === 'enable')
			{
				return true;
			}
			return false;
		}
		else
		{
			self::save_option_setting('trip_settings', 'trip_getdate', 'trip_getdate', $_action);
		}
	}


	public static function remove_cityplace($_id)
	{
		if($_id && is_numeric($_id) && \lib\db\myoption::remove($_id))
		{
			return true;
		}

		return false;
	}


	public static function user_travel_list($_type = 'family')
	{
		$user_id = \dash\user::id();
		if(!$user_id)
		{
			return false;
		}

		$travele_list = \dash\db::get("SELECT * FROM travels WHERE `user_id` = $user_id AND type = '$_type' AND status NOT IN ('admincancel') ORDER BY id DESC LIMIT 50 ");

		return $travele_list;
	}


	public static function cityplaceList()
	{
		$list = \dash\db\options::get(['cat' => self::$cityplace_cat]);

		$cityplaceList = [];

		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				if(isset($value['value']) && isset($value['meta']) && isset($value['status']) && $value['status'] === 'enable' && isset($value['id']))
				{
					$cityplaceList[] = ['city' => $value['value'], 'place' => $value['meta'], 'id' => $value['id']];
				}
			}
		}

		return $cityplaceList;
	}



	/**
	 * Gets the product.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The product.
	 */
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
			'in'    => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$option             = [];
		$option             = array_merge($default_args, $_args);

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

		if($option['in'] && $_string && in_array($option['in'], ['status', 'place', 'type']))
		{
			$option['travels.'.$option['in']] = $_string;
			$_string = null;
		}
		unset($option['in']);

		$result = \lib\db\travels::search($_string, $option, $field);

		return $result;
	}


	public static function set_cityplace($_city, $_place)
	{
		$cat = self::$cityplace_cat;

		if(mb_strlen($_city) > 50)
		{
			\dash\notif::error(T_("City name must be less than 50 character"), 'city');
			return false;
		}

		if(mb_strlen($_place) > 50)
		{
			\dash\notif::error(T_("Place name must be less than 50 character"), 'place');
			return false;
		}

		if(!$_city)
		{
			\dash\notif::error(T_("Please fill the city name"), 'city');
			return false;
		}


		if(!$_place)
		{
			\dash\notif::error(T_("Please fill the place name"), 'place');
			return false;
		}

		if(!in_array($_city, self::cityList()))
		{
			\dash\notif::error(T_("Please select city from the list"), 'city');
			return false;
		}

		$list = \dash\db\options::get(['cat' => $cat]);

		if(\lib\db\myoption::check_city_place_duplicate($_city, $_place, $cat))
		{
			\dash\notif::error(T_("Duplicate place in one city"), 'city');
			return false;
		}

		$insert_args =
		[
			'cat'   => $cat,
			'key'   => null,
			'value' => $_city,
			'meta'  => $_place,
		];
		\dash\db\options::insert($insert_args);
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_option = [])
	{
		$default_option =
		[
			'debug' => true,
			'force_admin' => false,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$force_admin = $_option['force_admin'];

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		$city = \dash\app::request('city');
		if(\dash\app::request('type') === 'group')
		{
			if(!$city || !in_array(T_($city), self::group_active_city()))
			{
				if(!$force_admin)
				{
					\dash\notif::error(_("Invalid city"), 'city');
					return false;
				}
			}
		}
		else
		{
			if(!$city || !in_array(T_($city), self::active_city()))
			{
				\dash\notif::error(_("Invalid city"), 'city');
				return false;
			}
		}


		$startdate = \dash\app::request('startdate');
		$startdate = \dash\utility\convert::to_en_number($startdate);

		if($startdate && strtotime($startdate) === false)
		{
			\dash\notif::error(_("Invalid parameter startdate"), 'startdate');
			return false;
		}

		if($startdate)
		{
			$startdate = date("Y-m-d", strtotime($startdate));
		}

		$enddate = \dash\app::request('enddate');
		$enddate = \dash\utility\convert::to_en_number($enddate);

		if($enddate && strtotime($enddate) === false)
		{
			\dash\notif::error(_("Invalid parameter enddate"), 'enddate');
			return false;
		}

		if($enddate)
		{
			$enddate = date("Y-m-d", strtotime($enddate));
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['awaiting','spam','cancel','reject','review','notanswer','queue','gone','delete','admincancel','draft']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$args              = [];
		$args['place']     = $city;
		$args['status']    = $status;
		$args['startdate'] = $startdate;
		$args['enddate']   = $enddate;

		return $args;
	}


	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args, $_option = [])
	{
		$default_option =
		[
			'debug'       => true,
			'force_admin' => false,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$force_admin = $_option['force_admin'];

		\dash\app::variable($_args);

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \dash\app::request(),
			]
		];

		if(!\dash\user::id())
		{
			\dash\app::log('api:product:user_id:notfound', null, $log_meta);
			if($_option['debug']) \dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!$force_admin)
		{
			$get_travel =
			[
				'user_id' => \dash\user::id(),
				'type'    => \dash\app::request('type'),
				'place'   => $args['place'],
				// 'status'  => ["IN", "('draft', 'awaiting')"],
				'status'  => ["IN", "('draft')"],
				'limit'   => 1
			];

			$check_duplicate_travel = \lib\db\travels::get($get_travel);
			if(isset($check_duplicate_travel['id']))
			{
				if(isset($check_duplicate_travel['status']) && $check_duplicate_travel['status'] === 'draft')
				{
					\dash\redirect::to(\dash\url::this(). '/profile?trip='. $check_duplicate_travel['id']);
				}

				\dash\notif::error(T_("You signup to this trip before, please wait for checking status of that trip"));
				return false;
			}

		}

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'draft';
		}

		// $args['user_id']     = \dash\user::id();
		if(!$force_admin)
		{
			$args['user_id']     = \dash\user::id();
		}
		else
		{
			$mobile = \dash\app::request('mobile');
			$mobile = \dash\utility\filter::mobile($mobile);
			if(!$mobile)
			{
				\dash\notif::error(T_("Mobile is required"), 'mobile');
				return false;
			}

			$user_id = \dash\db\users::get_by_mobile($mobile);
			if(isset($user_id['id']))
			{
				$args['user_id']     = $user_id['id'];
			}
			else
			{
				$args['user_id']     = \dash\db\users::signup(['mobile' => $mobile]);
			}
		}


		$args['type']        = \dash\app::request('type');

		$travel_id = \lib\db\travels::insert($args);

		if(!$travel_id)
		{
			\dash\notif::error(T_("No way to add travel"));
			return false;
		}

		if($force_admin)
		{
			\dash\log::set('AdminAddNewTrip', ['code' => $travel_id]);
		}

		\dash\temp::set('travel_user_id', $args['user_id']);

		return $travel_id;
	}


	public static function trip_gone_to_place($_trip)
	{
		if(!$_trip || !is_numeric($_trip))
		{
			return false;
		}

		$all_user   = [];
		$load_admin = \lib\db\travels::get(['id' => $_trip, 'limit' => 1]);

		$travel_meta = [];

		if(isset($load_admin['meta']) && $load_admin['meta'])
		{
			$travel_meta = json_decode($load_admin['meta'], true);
		}

		if(!is_array($travel_meta))
		{
			$travel_meta = [];
		}

		if(isset($travel_meta['set_all_nationalcode_partner']) && $travel_meta['set_all_nationalcode_partner'])
		{
			return false;
		}

		if(isset($load_admin['place']))
		{
			$place = $load_admin['place'];
		}
		else
		{
			return false;
		}

		if(isset($load_admin['user_id']))
		{
			$all_user[] = $load_admin['user_id'];
		}

		$load_partner = \lib\db\travelusers::get(['travel_id' => $_trip]);

		if(is_array($load_partner))
		{
			$all_user     = array_merge($all_user, array_column($load_partner, 'user_id'));
		}

		$all_user = array_unique($all_user);
		$all_user = array_filter($all_user);
		if(empty($all_user))
		{
			return false;
		}

		$all_user = implode(',', $all_user);

		$get_national_code = \dash\db\users::get(['id' => ["IN", "($all_user)"]]);
		if(!is_array($get_national_code))
		{
			return false;
		}

		$get_national_code = array_column($get_national_code, 'nationalcode');
		$get_national_code = array_filter($get_national_code);
		$get_national_code = array_unique($get_national_code);

		if(empty($get_national_code))
		{
			return false;
		}

		\lib\db\nationalcodes::set_travel($get_national_code, $place);

		$travel_meta['set_all_nationalcode_partner'] = true;

		\lib\db\travels::update(['meta' => json_encode($travel_meta, JSON_UNESCAPED_UNICODE)], $_trip);

	}


	public static function make_duplicate($_id, $_new_place)
	{
		if(!$_id || !is_numeric($_id))
		{
			return false;
		}

		$all_user   = [];
		$load_admin = \lib\db\travels::get(['id' => $_id, 'limit' => 1]);

		$travel_meta = [];

		if(isset($load_admin['meta']) && $load_admin['meta'])
		{
			$travel_meta = json_decode($load_admin['meta'], true);
		}

		if(!is_array($travel_meta))
		{
			$travel_meta = [];
		}

		if(isset($load_admin['place']))
		{
			$place = $load_admin['place'];
		}
		else
		{
			return false;
		}

		if($place === $_new_place)
		{
			\dash\notif::error(T_("Can not create duplicate of trip from one place"));
			return false;
		}

		$myKey = 'duplicate_travel_to_'. $_new_place;

		if(isset($travel_meta[$myKey]))
		{
			\dash\notif::error(T_("A copy of this trip has already been prepared"));
			return false;
		}

		if(isset($travel_meta['duplicate_from']))
		{
			\dash\notif::error(T_("This is a duplicate trip, can not duplicate again it!"));
			return false;
		}

		\dash\db::transaction();

		$new_travel_id = \lib\db\travels::make_duplicate($_id, $_new_place, ['key' => 'duplicate_from', 'old_place' => $place, 'old_id' => $_id, 'user_id' => \dash\user::id(), 'status' => 'copied from '. $place]);
		if($new_travel_id)
		{
			$copy_travelusers = \lib\db\travelusers::make_duplicate($new_travel_id, $_id);
			if($copy_travelusers)
			{
				$travel_meta[$myKey] =
				[
					'status'     => 'copied for '. $_new_place,
					'new_travel' => $new_travel_id,
					'user_id'    => \dash\user::id(),
					'date'       => date("Y-m-d H:i:s"),
				];

				\lib\db\travels::update(['meta' => json_encode($travel_meta, JSON_UNESCAPED_UNICODE)], $_id);
				\dash\db::commit();
				return true;
			}
		}

		\dash\db::rollback();
		return false;
	}
}
?>