<?php
namespace lib\app;

class need
{
	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_option = [])
	{
		$title   = null;
		$request = null;
		$amount  = null;
		$fileurl = null;
		$desc    = null;
		$type    = null;
		$status  = null;

		$default_option =
		[
			'debug'    => true,
			'service'  => false,
			'is_other' => false,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$is_service = false;
		if($_option['service'])
		{
			$is_service = true;
		}
		$is_other = false;
		if($_option['is_other'])
		{
			$is_other = true;
		}

		$title = \dash\app::request('title');
		$title = trim($title);
		if($title && mb_strlen($title) >= 200)
		{
			\dash\notif::error(T_("Please set a valid title"), 'title');
			return false;
		}

		if(!$title)
		{
			\dash\notif::error(T_("Please set title"), 'title');
			return false;
		}

		$request = \dash\app::request('count');
		if(!$is_other)
		{
			$request = trim($request);
			$request = \dash\utility\convert::to_en_number($request);
			if(!$is_service && !is_numeric($request))
			{
				\dash\notif::error(T_("Please set a valid request"), 'request');
				return false;
			}

			if(!$is_service && intval($request) > 1E+8)
			{
				\dash\notif::error(T_("Request is too large"), 'request');
				return false;
			}

			$request = intval($request);

			$amount = \dash\app::request('amount');
			$amount = trim($amount);
			$amount = \dash\utility\convert::to_en_number($amount);
			if(!$is_service && $amount && !is_numeric($amount))
			{
				\dash\notif::error(T_("Please set a valid amount"), 'amount');
				return false;
			}

			if(!$is_service && $amount && intval($amount) > 1E+8)
			{
				\dash\notif::error(T_("Amount is too large"), 'amount');
				return false;
			}

			if(!$is_service && $amount)
			{
				$amount = intval($amount);
			}

			$type = \dash\app::request('type');
			if($type && !in_array($type, ['product', 'expertise']))
			{
				\dash\notif::error(T_("Please set a valid type"), 'type');
				return false;
			}
		}
		else
		{
			$type = \dash\app::request('type');
		}


		$fileurl = \dash\app::request('fileurl');
		$fileurl = trim($fileurl);
		if($fileurl && mb_strlen($fileurl) >= 1000)
		{
			\dash\notif::error(T_("Please set a valid fileurl"), 'fileurl');
			return false;
		}

		$desc = \dash\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) >= 1000)
		{
			\dash\notif::error(T_("Please set a valid desc"), 'desc');
			return false;
		}

		$linkurl = \dash\app::request('linkurl');
		if($linkurl && mb_strlen($linkurl) >= 200)
		{
			\dash\notif::error(T_("Please set a valid linkurl"), 'linkurl');
			return false;
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable','disable']))
		{
			\dash\notif::error(T_("Please set a valid status"), 'status');
			return false;
		}

		$lang = \dash\app::request('lang');

		if($lang && !\dash\language::check($lang))
		{
			\dash\notif::error(T_("Please set a valid language"), 'language');
			return false;
		}

		$sort = \dash\app::request('sort');

		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Please set a valid sort as a number"), 'sort');
			return false;
		}


		$count = \dash\app::request('count');

		if($count && !is_numeric($count))
		{
			\dash\notif::error(T_("Please set a valid count as a number"), 'count');
			return false;
		}


		$every = \dash\app::request('every');

		if($every && !is_numeric($every))
		{
			\dash\notif::error(T_("Please set a valid every as a number"), 'every');
			return false;
		}

		if(!$lang)
		{
			$lang = \dash\language::current();
		}

		$term = \dash\app::request('term');

		$allowpirce = \dash\app::request('allowpirce') ? 1 : null;
		$iactive = \dash\app::request('iactive') ? 1 : null;

		$price1 = self::check_price('price1');
		$price2 = self::check_price('price2');
		$price3 = self::check_price('price3');
		$title1 = self::check_title('title1');
		$title2 = self::check_title('title2');
		$title3 = self::check_title('title3');

		if(!\dash\engine\process::status())
		{
			return false;
		}

		$args               = [];
		$args['count']      = $count;
		$args['every']      = $every;
		$args['sort']       = $sort;
		$args['term']       = $term;
		$args['lang']       = $lang;
		$args['title']      = $title;
		$args['request']    = $request;
		$args['amount']     = $amount;
		$args['fileurl']    = $fileurl;
		$args['desc']       = $desc;
		$args['linkurl']    = $linkurl;
		$args['type']       = $type;
		$args['status']     = $status;
		$args['allowpirce'] = $allowpirce;
		$args['iactive']    = $iactive;
		$args['price1']     = $price1;
		$args['price2']     = $price2;
		$args['price3']     = $price3;
		$args['title1']     = $title1;
		$args['title2']     = $title2;
		$args['title3']     = $title3;

		return $args;
	}


	private static function check_price($_price)
	{
		$price = \dash\app::request($_price);
		if(!$price)
		{
			return null;
		}

		if($price && !is_numeric($price))
		{
			\dash\notif::error(T_("Invalid price"), $_price);
			return false;
		}

		$price = intval($price);
		if($price > 1E+9)
		{
			\dash\notif::error(T_("Price is out of range"), $_price);
			return false;
		}

		return $price;
	}


	private static function check_title($_title)
	{
		$title = \dash\app::request($_title);
		if(!$title)
		{
			return null;
		}

		if($title && mb_strlen($title) > 100)
		{
			\dash\notif::error(T_("Please set title less than 100 character"), $_title);
			return false;
		}

		return $title;
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

				case 'fileurl':
					if($value)
					{
						$result[$key] = $value;
					}
					else
					{
						$result[$key] = \dash\url::static(). '/images/logo.png';
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
			'debug'    => true,
			'service'  => false,
			'is_other' => false,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\dash\app::variable($_args, ['raw_field' => ['term']]);

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

		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'enable';
		}

		$return = [];

		$need_id = \lib\db\needs::insert($args);

		if(!$need_id)
		{
			\dash\notif::error(T_("No way to insert need"), 'db', 'system');
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
			'debug'    => true,
			'service'  => false,
			'is_other' => false,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\dash\app::variable($_args, ['raw_field' => ['term']]);

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

		$check_id = \lib\db\needs::get(['id' => $_id, 'limit' => 1]);
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

		if(!\dash\app::isset_request('fileurl'))    unset($args['fileurl']);
		if(!\dash\app::isset_request('term'))       unset($args['term']);


		if(!isset($args['status']) || (isset($args['status']) && !$args['status']))
		{
			$args['status']  = 'enable';
		}

		$return = [];

		$need_id = \lib\db\needs::update($args, $_id);

		return true;
	}

	public static function active_list($_type)
	{
		return self::list($_type, true);

	}

	public static function list($_type, $_enable = false)
	{
		if($_enable)
		{
			$list = \lib\db\needs::get_sort(['type' => $_type, 'status' => 'enable', 'lang' => \dash\language::current()]);
		}
		else
		{
			$list = \lib\db\needs::get_sort(['type' => $_type, 'lang' => \dash\language::current()]);
		}
		return array_map(['self', 'ready'], $list);
	}

}
?>