<?php
namespace lib\app;

class service
{
	public static $sort_field =
	[
		'id',
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

		$expert = \lib\app::request('expert');
		if($expert && mb_strlen($expert) > 200)
		{
			\lib\debug::error(T_("You must set expert less than 200 character"), 'expert');
			return false;
		}

		$job = \lib\app::request('job');
		if($job && mb_strlen($job) > 200)
		{
			\lib\debug::error(T_("You must set job less than 200 character"), 'job');
			return false;
		}

		$expertvalue = \lib\app::request('expertvalue');
		if($expertvalue && mb_strlen($expertvalue) > 200)
		{
			\lib\debug::error(T_("You must set expert value less than 200 character"), 'expertvalue');
			return false;
		}

		$expertyear = \lib\app::request('expertyear');
		if($expertyear && !is_numeric($expertyear))
		{
			\lib\debug::error(T_("You must set the expert year as a number"), 'expertyear');
			return false;
		}

		$arabiclang = \lib\app::request('arabiclang');


		$car = \lib\app::request('car');
		if($car && mb_strlen($car) > 200)
		{
			\lib\debug::error(T_("Invalid car"), 'car');
			return false;
		}

		$file = \lib\app::request('file');
		if($file && mb_strlen($file) > 2000)
		{
			\lib\debug::error(T_("Invalid file"), 'file');
			return false;
		}

		$startdate = \lib\app::request('startdate');
		$startdate = \lib\utility\convert::to_en_number($startdate);
		if($startdate && strtotime($startdate) === false)
		{
			\lib\debug::error(T_("Invalid startdate"), 'startdate');
			return false;
		}
		if($startdate)
		{
			$startdate = date("Y-m-d", strtotime($startdate));
		}


		$enddate = \lib\app::request('enddate');
		$enddate = \lib\utility\convert::to_en_number($enddate);
		if($enddate && strtotime($enddate) === false)
		{
			\lib\debug::error(T_("Invalid enddate"), 'enddate');
			return false;
		}
		if($enddate)
		{
			$enddate = date("Y-m-d", strtotime($enddate));
		}

		$status = \lib\app::request('status');
		if($expert && mb_strlen($status) > 200)
		{
			\lib\debug::error(T_("Invalid status"), 'status');
			return false;
		}

		$desc = \lib\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) >= 200)
		{
			\lib\debug::error(T_("Please set a valid desc"), 'desc');
			return false;
		}

		$status = \lib\app::request('status');
		if($status && !in_array($status, ['draft','awaiting','accept','reject','cancel', 'spam']))
		{
			\lib\debug::error(T_("Please set a valid status"), 'status');
			return false;
		}


		$args                = [];
		$args['expert']      = $expert;
		$args['job']         = $job;
		$args['expertvalue'] = $expertvalue;
		$args['expertyear']  = $expertyear;
		$args['arabiclang']  = $arabiclang;
		$args['car']         = $car;
		$args['file']        = $file;
		$args['startdate']   = $startdate;
		$args['enddate']     = $enddate;
		$args['status']      = $status;
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
						$result[$key] = \lib\utility\shortURL::encode($value);
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
		if(!\lib\user::id())
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

		\lib\app::variable($_args);

		if(!\lib\user::id())
		{
			\lib\debug::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'enable';
		}

		$return = [];

		$service_id = \lib\db\services::insert($args);

		if(!$service_id)
		{
			\lib\debug::error(T_("No way to insert service"), 'db', 'system');
			return false;
		}
		return true;
	}

	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function edit($_id, $_args, $_option = [])
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

		\lib\app::variable($_args);

		if(!\lib\user::id())
		{
			\lib\debug::error(T_("User not found"), 'user');
			return false;
		}

		if(!$_id || !is_numeric($_id))
		{
			\lib\debug::error(T_("Id not found"), 'id');
			return false;
		}

		$check_id = \lib\db\services::get(['id' => $_id, 'limit' => 1]);
		if(!isset($check_id['id']))
		{
			\lib\debug::error(T_("Id not found"), 'id');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		if(!\lib\app::isset_request('fileurl'))         unset($args['fileurl']);


		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'enable';
		}

		$return = [];

		$service_id = \lib\db\services::update($args, $_id);

		return true;
	}


	public static function user_service_list()
	{
		$user_id = \lib\user::id();
		if(!$user_id)
		{
			return false;
		}
		return \lib\db::get("SELECT * FROM services WHERE services.user_id = $user_id ORDER BY id DESC LIMIT 50");
	}
}
?>