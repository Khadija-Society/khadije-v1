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
		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$title = \lib\app::request('title');
		$title = trim($title);
		if($title && mb_strlen($title) >= 200)
		{
			\lib\debug::error(T_("Please set a valid title"), 'title');
			return false;
		}

		$request = \lib\app::request('count');
		$request = trim($request);
		$request = \lib\utility\convert::to_en_number($request);
		if(!is_numeric($request))
		{
			\lib\debug::error(T_("Please set a valid request"), 'request');
			return false;
		}

		if(intval($request) > 1E+8)
		{
			\lib\debug::error(T_("Request is too large"), 'request');
			return false;
		}

		$request = intval($request);


		$amount = \lib\app::request('amount');
		$amount = trim($amount);
		$amount = \lib\utility\convert::to_en_number($amount);
		if($amount && !is_numeric($amount))
		{
			\lib\debug::error(T_("Please set a valid amount"), 'amount');
			return false;
		}

		if($amount && intval($amount) > 1E+8)
		{
			\lib\debug::error(T_("Amount is too large"), 'amount');
			return false;
		}

		if($amount)
		{
			$amount = intval($amount);
		}

		$fileurl = \lib\app::request('fileurl');
		$fileurl = trim($fileurl);
		if($fileurl && mb_strlen($fileurl) >= 1000)
		{
			\lib\debug::error(T_("Please set a valid fileurl"), 'fileurl');
			return false;
		}

		$desc = \lib\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) >= 200)
		{
			\lib\debug::error(T_("Please set a valid desc"), 'desc');
			return false;
		}

		$type = \lib\app::request('type');
		if($type && !in_array($type, ['product', 'expertise']))
		{
			\lib\debug::error(T_("Please set a valid type"), 'type');
			return false;
		}

		$status = \lib\app::request('status');
		if($status && !in_array($status, ['enable','disable']))
		{
			\lib\debug::error(T_("Please set a valid status"), 'status');
			return false;
		}



		$args            = [];
		$args['title']   = $title;
		$args['request'] = $request;
		$args['amount']  = $amount;
		$args['fileurl'] = $fileurl;
		$args['desc']    = $desc;
		$args['type']    = $type;
		$args['status']  = $status;

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

		$need_id = \lib\db\needs::insert($args);

		if(!$need_id)
		{
			\lib\debug::error(T_("No way to insert need"), 'db', 'system');
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

		$check_id = \lib\db\needs::get(['id' => $_id, 'limit' => 1]);
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

		$need_id = \lib\db\needs::update($args, $_id);

		return true;
	}


	public static function list($_type)
	{
		return \lib\db\needs::get(['type' => $_type]);
	}
}
?>