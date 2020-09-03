<?php
namespace lib\app;

/**
 * Class for protectiontype.
 */
class protectiontype
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("protectiontype id not set"));
			return false;
		}

		$get = \lib\db\protectiontype::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid protectiontype id"));
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

			$load = \lib\db\protectiontype::get($load_args);

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
		if(\dash\app::isset_request('title'))
		{
			$title = trim($title);
			if(!$title)
			{
				\dash\notif::error(T_("Please fill the title"), 'title');
				return false;
			}

			if(mb_strlen($title) > 150)
			{
				\dash\notif::error(T_("Please fill the title less than 150 character"), 'title');
				return false;
			}

			$check_duplicate = \lib\db\protectiontype::get(['title' => $title, 'limit' => 1]);
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
		}



		$status = \dash\app::request('status');
		if($status && !in_array($status, [ 'enable', 'deleted']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}


		$args['title']             = $title;

		$args['status']            = $status;



		return $args;
	}





	/**
	 * add new protectiontype
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

		$args['datecreated'] = date("Y-m-d H:i:s");

		$protectiontype_id = \lib\db\protectiontype::insert($args);

		if(!$protectiontype_id)
		{
			\dash\notif::error(T_("No way to insert protectiontype"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($protectiontype_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("protect type successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'title',
		'id',

	];


	/**
	 * Gets the protectiontype.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The protectiontype.
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

		$result            = \lib\db\protectiontype::search($_string, $_args);
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


	public static function get_all()
	{

		$result            = \lib\db\protectiontype::get_all();
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
	 * edit a protectiontype
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

		if(!\dash\app::isset_request('status')) unset($args['status']);



		if(!empty($args))
		{
			$update = \lib\db\protectiontype::update($args, $id);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of protectiontype to load in api
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



				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}

}
?>