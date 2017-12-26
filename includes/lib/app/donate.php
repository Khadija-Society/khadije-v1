<?php
namespace lib\app;

class donate
{
	public static $way_key = 'hazinekard_list';

	public static function remove_way($_way)
	{
		$_way = trim($_way);

		$old = self::way_list();
		if(array_search($_way, $old) === false)
		{
			\lib\debug::error(T_("This way is not in your list!"));
			return false;
		}
		unset($old[array_search($_way, $old)]);

		self::set_way($old, true);
		return true;

	}

	public static function way_list()
	{
		$list = \lib\db\options::get(['key' => self::$way_key, 'limit' => 1]);

		$way_list = [];

		if(isset($list['meta']))
		{
			if(is_array($list['meta']))
			{
				$way_list = $list['meta'];
			}
			else
			{
				$way_list = json_decode($list['meta']);
			}
		}

		if(!is_array($way_list))
		{
			$way_list = [];
		}
		return $way_list;
	}


	public static function set_way($_way, $_set_all_way = false)
	{
		if(!$_set_all_way)
		{
			$_way = trim($_way);

			if(!$_way)
			{
				\lib\debug::error(T_("Please set way"), 'way');
				return false;
			}

			if(mb_strlen($_way) > 150)
			{
				\lib\debug::error(T_("Please set way less than 150 character"), 'way');
				return false;
			}
		}

		$key = self::$way_key;

		$list = \lib\db\options::get(['key' => $key, 'limit' => 1]);

		$update = false;

		if(isset($list['id']))
		{
			$update = true;
		}

		$way_list = [];

		if($_set_all_way)
		{
			$way_list = $_way;
		}
		else
		{
			if(isset($list['meta']))
			{
				if(is_array($list['meta']))
				{
					$way_list = $list['meta'];
				}
				elseif(substr($list['meta'], 0,1) === '[')
				{
					$way_list = json_decode($list['meta']);
				}
				else
				{
					$way_list = [];
				}
			}

			if(!is_array($way_list))
			{
				$way_list = [];
			}

			if(in_array($_way, $way_list))
			{
				\lib\debug::error(T_("Duplicate way"), 'way');
				return false;
			}

			array_push($way_list, $_way);
		}

		$meta = json_encode($way_list, JSON_UNESCAPED_UNICODE);

		if($update)
		{
			\lib\db\options::update(['meta' => $meta], $list['id']);
		}
		else
		{
			$insert_args =
			[
				'key'  => $key,
				'meta' => $meta,
			];
			\lib\db\options::insert($insert_args);
		}

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

		$name = \lib\app::request('name');
		$name = trim($name);
		if($name && mb_strlen($name) >= 500)
		{
			// \lib\app::log('api:product:name:max:lenght', \lib\user::id(), $log_meta);
			if($_option['debug']) debug::error(T_("Product name must be less than 500 character"), 'name');
			return false;
		}

		$args                    = [];
		$args['title']           = $title;

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

		if(!\lib\store::id())
		{
			\lib\app::log('api:product:store_id:notfound', null, $log_meta);
			if($_option['debug']) \lib\debug::error(T_("Store not found"), 'subdomain');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		$args['store_id'] = \lib\store::id();
		$args['creator']  = \lib\user::id();

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'available';
		}

		if(!isset($args['title']) || (isset($args['title']) && !$args['title']))
		{
			\lib\app::log('api:product:title:not:set', \lib\user::id(), $log_meta);
			if($_option['debug']) \lib\debug::error(T_("Product title can not be null"), 'title');
			return false;
		}

		$return = [];

		// \lib\temp::set('last_product_added', isset($args['slug'])? $args['slug'] : null);

		$product_id = \lib\db\products::insert($args);

		if(!$product_id)
		{
			\lib\app::log('api:product:no:way:to:insert:product', \lib\user::id(), $log_meta);
			if($_option['debug']) \lib\debug::error(T_("No way to insert product"), 'db', 'system');
			return false;
		}

		// the product was inserted
		// set the productprice record
		$insert_productprices =
		[
			'product_id'      => $product_id,
			'creator'         => \lib\user::id(),
			'startdate'       => date("Y-m-d H:i:s"),
			'startshamsidate' => \lib\utility\jdate::date("Ymd", false, false),
			'enddate'         => null,
			'endshamsidate'   => null,
			'buyprice'        => $args['buyprice'],
			'price'           => $args['price'],
			'discount'        => $args['discount'],
			'discountpercent' => $args['discountpercent'],
		];
		\lib\db\productprices::insert($insert_productprices);


		$return['product_id'] = \lib\utility\shortURL::encode($product_id);

		if(\lib\debug::$status)
		{
			if($_option['debug']) \lib\debug::true(T_("Product successfuly added"));
		}

		self::clean_cache('var');

		return $return;
	}
}
?>