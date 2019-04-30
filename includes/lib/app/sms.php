<?php
namespace lib\app;

/**
 * Class for sms.
 */
class sms
{

	// not remvoe html tag and single or dbl qute from this field
	// because get from editor
	public static $raw_field =
	[
		// no field
	];

	public static $sort_field =
	[
		'title',
		'type',
		'status',
		'analyze',
		'ismoney',
	];


	/**
	 * add new sms
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		$raw_field =

		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
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

		$args['creator']  = \dash\user::id();

		$args = array_filter($args);

		$sms_id = \lib\db\sms::insert($args);

		if(!$sms_id)
		{
			\dash\notif::error(T_("No way to insert sms"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($sms_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Sms group successfuly added"));
		}

		return $return;
	}




	/**
	 * Gets the sms.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The sms.
	 */
	public static function list($_string = null, $_args = [])
	{
		if(!\dash\user::id())
		{
			return false;
		}

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


		$result            = \lib\db\sms::search($_string, $_args);
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
	 * edit a sms
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			return false;
		}

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('analyze')) unset($args['analyze']);
		if(!\dash\app::isset_request('ismoney')) unset($args['ismoney']);
		if(!\dash\app::isset_request('answer')) unset($args['answer']);

		if(!empty($args))
		{
			$update = \lib\db\sms::update($args, $id);
			\dash\notif::ok(T_("Sms group successfully updated"));

		}
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Sms group id not set"));
			return false;
		}


		$get = \lib\db\sms::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid sms id"));
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
		if(!$title && \dash\app::isset_request('title'))
		{
			\dash\notif::error(T_("Please fill course title"), 'title');
			return false;
		}

		if($title && mb_strlen($title) > 500)
		{
			\dash\notif::error(T_("Please fill course title less than 500 character"), 'title');
			return false;
		}

		if($title)
		{
			$check_duplicate = \lib\db\sms::get(['title' => $title, 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate sms title"), 'title');
					return false;
				}
			}
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable', 'deleted', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of sms"), 'status');
			return false;
		}

		$type = \dash\app::request('type');
		if($type && !in_array($type, ['blacklist','family','bank','other','auto']))
		{
			\dash\notif::error(T_("Invalid type of sms"), 'type');
			return false;
		}

		$analyze = \dash\app::request('analyze') ? 1 : null;
		$ismoney = \dash\app::request('ismoney') ? 1 : null;
		$answer  = \dash\app::request('answer');

		$args            = [];
		$args['title']   = $title;
		$args['status']  = $status;
		$args['type']    = $type;
		$args['analyze'] = $analyze;
		$args['ismoney'] = $ismoney;
		$args['answer']  = $answer;

		return $args;
	}


	/**
	 * ready data of sms to load in api
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
				case 'creator':

					$result[$key] = \dash\coding::encode($value);
					break;

				case 'answer':
					$result[$key] = json_decode($value, true);
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