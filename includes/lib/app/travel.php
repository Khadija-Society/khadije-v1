<?php
namespace lib\app;

class travel
{
	public static $cityplace_cat = 'city_place';


	public static function remove_cityplace($_id)
	{
		if($_id && is_numeric($_id) && \lib\db\myoption::remove($_id))
		{
			return true;
		}

		return false;
	}


	public static function cityplace_list()
	{
		$list = \lib\db\options::get(['cat' => self::$cityplace_cat]);

		$cityplace_list = [];

		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				if(isset($value['value']) && isset($value['meta']) && isset($value['status']) && $value['status'] === 'enable' && isset($value['id']))
				{
					$cityplace_list[] = ['city' => $value['value'], 'place' => $value['meta'], 'id' => $value['id']];
				}
			}
		}

		return $cityplace_list;
	}


	public static function set_cityplace($_city, $_place)
	{
		$cat = self::$cityplace_cat;

		if(mb_strlen($_city) > 50)
		{
			\lib\debug::error(T_("City name must be less than 50 character"), 'city');
			return false;
		}

		if(mb_strlen($_place) > 50)
		{
			\lib\debug::error(T_("Place name must be less than 50 character"), 'place');
			return false;
		}

		if(!$_city)
		{
			\lib\debug::error(T_("Please fill the city name"), 'city');
			return false;
		}


		if(!$_place)
		{
			\lib\debug::error(T_("Please fill the place name"), 'place');
			return false;
		}

		$list = \lib\db\options::get(['cat' => $cat]);

		if(\lib\db\myoption::check_city_place_duplicate($_city, $_place, $cat))
		{
			\lib\debug::error(T_("Duplicate place in one city"), 'city');
			return false;
		}

		$insert_args =
		[
			'cat'   => $cat,
			'key'   => null,
			'value' => $_city,
			'meta'  => $_place,
		];
		\lib\db\options::insert($insert_args);

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
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\app::request(),
			]
		];

		$cityplace = \lib\app::request('cityplace');
		if(!$cityplace || !ctype_digit($cityplace))
		{
			\lib\debug::error(_("Please fill the cityplace"), 'cityplace');
			return false;
		}

		$cityplace_decode = \lib\db\options::get(['id' => $cityplace, 'limit' => 1]);

		if(!isset($cityplace_decode['id']) || !isset($cityplace_decode['value']) || !isset($cityplace_decode['meta']))
		{
			\lib\debug::error(T_("Invalid city place code!"), 'cityplace');
			return false;
		}

		$city  = $cityplace_decode['value'];
		$place = $cityplace_decode['meta'];

		$startdate = \lib\app::request('startdate');
		$startdate = \lib\utility\convert::to_en_number($startdate);
		if(!$startdate)
		{
			\lib\debug::error(_("Please fill the startdate"), 'startdate');
			return false;
		}

		if(strtotime($startdate) === false)
		{
			\lib\debug::error(_("Invalid parameter startdate"), 'startdate');
			return false;
		}

		$startdate = date("Y-m-d", strtotime($startdate));

		$enddate = \lib\app::request('enddate');
		$enddate = \lib\utility\convert::to_en_number($enddate);

		if(!$enddate)
		{
			\lib\debug::error(_("Please fill the enddate"), 'enddate');
			return false;
		}

		if(strtotime($enddate) === false)
		{
			\lib\debug::error(_("Invalid parameter enddate"), 'enddate');
			return false;
		}
		$enddate = date("Y-m-d", strtotime($enddate));


		$child = \lib\app::request('child');

		if(!$child || !is_array($child) || empty($child))
		{
			\lib\debug::error(_("Please fill the child"), 'child');
			return false;
		}

		$all_id                  = implode(',', $child);
		$check_all_user_is_child = \lib\db\users::get(['parent' => \lib\user::id(), 'id' => ['IN', "($all_id)"]]);
		if(is_array($check_all_user_is_child))
		{
			$all_real_id = array_column($check_all_user_is_child, 'id');
			foreach ($child as $key => $value)
			{
				if(!in_array($value, $all_real_id))
				{
					\lib\debug::error(T_("Invalid child detail!"));
					return fales;
				}
			}
		}

		$args              = [];
		$args['place']     = $city;
		$args['hotel']     = $place;
		$args['startdate'] = $startdate;
		$args['enddate']   = $enddate;
		$args['child']     = $child;

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

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\app::request(),
			]
		];

		if(!\lib\user::id())
		{
			\lib\app::log('api:product:user_id:notfound', null, $log_meta);
			if($_option['debug']) \lib\debug::error(T_("User not found"), 'user');
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

		$child               = $args['child'];

		$args['user_id']     = \lib\user::id();
		$args['countpeople'] = count($child);
		$args['type']        = 'family';

		unset($args['child']);

		$travel_id = \lib\db\travels::insert($args);

		if(!$travel_id)
		{
			\lib\debug::error(T_("No way to add travel"));
			return false;
		}

		$travelusers = [];

		foreach ($child as $key => $value)
		{
			$travelusers[] = ['travel_id' => $travel_id, 'user_id' => $value];
		}

		if(!empty($travelusers))
		{
			\lib\db\travelusers::multi_insert($travelusers);
		}

		return true;
	}
}
?>