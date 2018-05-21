<?php
namespace lib\app;

class service
{
	public static $sort_field =
	[
		'id',
		'expert',
		'job',
		'expertvalue',
		'expertyear',
		'startdate',
		'enddate',
		'status',
	];


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
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);


		$job = \dash\app::request('job');
		if($job && mb_strlen($job) > 200)
		{
			\dash\notif::error(T_("You must set job less than 200 character"), 'job');
			return false;
		}

		$expertvalue = \dash\app::request('expertvalue');
		if($expertvalue && mb_strlen($expertvalue) > 200)
		{
			\dash\notif::error(T_("You must set expert value less than 200 character"), 'expertvalue');
			return false;
		}

		$expertyear = \dash\app::request('expertyear');
		if($expertyear && !is_numeric($expertyear))
		{
			\dash\notif::error(T_("You must set the expert year as a number"), 'expertyear');
			return false;
		}

		$arabiclang = \dash\app::request('arabiclang');
		$arabiclang  = $arabiclang ? 1 : 0;

		$car = \dash\app::request('car');
		if($car && mb_strlen($car) > 200)
		{
			\dash\notif::error(T_("Invalid car"), 'car');
			return false;
		}

		$file = \dash\app::request('file');
		if($file && mb_strlen($file) > 2000)
		{
			\dash\notif::error(T_("Invalid file"), 'file');
			return false;
		}

		$startdate = \dash\app::request('startdate');
		$startdate = \dash\utility\convert::to_en_number($startdate);
		if($startdate && strtotime($startdate) === false)
		{
			\dash\notif::error(T_("Invalid startdate"), 'startdate');
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
			\dash\notif::error(T_("Invalid enddate"), 'enddate');
			return false;
		}
		if($enddate)
		{
			$enddate = date("Y-m-d", strtotime($enddate));
		}

		$status = \dash\app::request('status');
		if($status && mb_strlen($status) > 200)
		{
			\dash\notif::error(T_("Invalid status"), 'status');
			return false;
		}

		$desc = \dash\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) >= 200)
		{
			\dash\notif::error(T_("Please set a valid desc"), 'desc');
			return false;
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft','awaiting','accept','reject','cancel', 'spam']))
		{
			\dash\notif::error(T_("Please set a valid status"), 'status');
			return false;
		}

		$type = \dash\app::request('type');


		$args                = [];

		$args['type']         = $type;
		$args['job']         = $job;
		$args['expertvalue'] = $expertvalue;
		$args['expertyear']  = $expertyear;
		$args['arabiclang']  = $arabiclang;
		$args['car']         = $car;
		$args['file']        = $file;
		$args['startdate']   = $startdate;
		$args['enddate']     = $enddate;
		$args['desc']        = $desc;
		$args['status']      = $status;

		return $args;
	}


	/**
	 * ready data of product to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];

		if(!is_array($_data))
		{
			return null;
		}

		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'creator':
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
					$result[$key] = isset($value) ? (string) $value : null;
					break;
			}
		}
		return $result;
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

		unset($option['in']);

		$result = \lib\db\services::search($_string, $option, $field);

		return $result;
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
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}
		$need_id = \dash\app::request('need_id');

		if(!$need_id || !is_numeric($need_id))
		{
			\dash\notif::error(T_("Service id not found"));
			return false;
		}

		$need_detail = \lib\db\needs::get(['id' => $need_id, 'limit' => 1]);
		if(!isset($need_detail['id']) || !isset($need_detail['status']))
		{
			\dash\notif::error(T_("Service id is invalid"));
			return false;
		}

		if($need_detail['status'] != 'enable')
		{
			\dash\notif::error(T_("This service is unavalible"));
			return false;
		}

		$args['expert']  = $need_detail['title'];

		$args['user_id'] = \dash\user::id();

		$check_duplicate = \lib\db\services::get(['user_id' => \dash\user::id(), 'expert' => $args['expert'], 'status' => ["IN", "('draft','awaiting','accept','spam')"], 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			\dash\notif::error(T_("You register to this service before"));
			return false;
		}

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'draft';
		}

		$return = [];

		$service_id = \lib\db\services::insert($args);

		if(!$service_id)
		{
			\dash\notif::error(T_("No way to insert service"), 'db', 'system');
			return false;
		}
		return $service_id;
	}

	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id, $_option = [])
	{
		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		if(!$_id || !is_numeric($_id))
		{
			\dash\notif::error(T_("Id not found"), 'id');
			return false;
		}

		$check_id = \lib\db\services::get(['id' => $_id, 'user_id' => \dash\user::id(), 'limit' => 1]);
		if(!isset($check_id['id']))
		{
			\dash\notif::error(T_("Id not found"), 'id');
			return false;
		}

		// check args
		$args = self::check($_option);



		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}


		if(!\dash\app::isset_request('file'))         unset($args['file']);

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'draft';
		}

		$return = [];

		$service_id = \lib\db\services::update($args, $_id);

		return true;
	}


	public static function user_serviceList($_type = 'khadem')
	{
		$user_id = \dash\user::id();
		if(!$user_id)
		{
			return false;
		}
		return \dash\db::get("SELECT * FROM services WHERE services.user_id = $user_id AND services.type = '$_type' ORDER BY id DESC LIMIT 50");
	}
}
?>