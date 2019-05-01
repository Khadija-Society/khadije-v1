<?php
namespace lib\app;

/**
 * Class for smsgroupfilter.
 */
class smsgroupfilter
{

	// not remvoe html tag and single or dbl qute from this field
	// because get from editor
	public static $raw_field =
	[
		// no field
	];

	public static $sort_field =
	[
		'number',
		'slug',
		'status',
		'datecreated',
	];


	/**
	 * add new smsgroupfilter
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

		$args = array_filter($args);

		$smsgroupfilter_id = \lib\db\smsgroupfilter::insert($args);

		if(!$smsgroupfilter_id)
		{
			\dash\notif::error(T_("No way to insert smsgroupfilter"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($smsgroupfilter_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Sms group filter successfuly added"));
		}

		return $return;
	}




	/**
	 * Gets the smsgroupfilter.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The smsgroupfilter.
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


		$result            = \lib\db\smsgroupfilter::search($_string, $_args);
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
	 * edit a smsgroupfilter
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

		if(!\dash\app::isset_request('number')) unset($args['number']);
		if(!\dash\app::isset_request('group_id')) unset($args['group_id']);
		if(!\dash\app::isset_request('text')) unset($args['text']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('exactly')) unset($args['exactly']);
		if(!\dash\app::isset_request('contain')) unset($args['contain']);


		if(!empty($args))
		{
			$update = \lib\db\smsgroupfilter::update($args, $id);
			\dash\notif::ok(T_("Sms group filter successfully updated"));

		}
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Sms group filter id not set"));
			return false;
		}


		$get = \lib\db\smsgroupfilter::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid smsgroupfilter id"));
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
		$group_id = \dash\app::request('group_id');
		$group_id = \dash\coding::decode($group_id);
		if(!$group_id)
		{
			\dash\notif::error(T_("Invalid group id"));
			return false;
		}

		$number = \dash\app::request('number');
		if(!$number && \dash\app::isset_request('number'))
		{
			\dash\notif::error(T_("Please fill number"), 'number');
			return false;
		}

		if($number && mb_strlen($number) > 100)
		{
			\dash\notif::error(T_("Please fill number less than 100 character"), 'number');
			return false;
		}

		if($number)
		{
			$check_duplicate = \lib\db\smsgroupfilter::get(['group_id' => $group_id, 'number' => $number, 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate smsgroupfilter number"), 'number');
					return false;
				}
			}
		}

		$type = \dash\app::request('type');
		if($type && !in_array($type, ['number','answer','analyze','other']))
		{
			\dash\notif::error(T_("Invalid type"), 'type');
			return false;
		}

		$text    = \dash\app::request('text');
		$exactly = \dash\app::request('exactly') ? 1 : null;
		$contain = \dash\app::request('contain') ? 1 : null;

		if(!$number && $type === 'number')
		{
			\dash\notif::error(T_("Please fill the number"), 'number');
			return false;
		}


		if(!$text && $type === 'answer')
		{
			\dash\notif::error(T_("Please fill the answer"), 'text');
			return false;
		}

		$args             = [];
		$args['group_id'] = $group_id;
		$args['number']   = $number;
		$args['text']     = $text;
		$args['type']     = $type;
		$args['exactly']  = $exactly;
		$args['contain']  = $contain;

		return $args;
	}


	public static function remove($_id)
	{
		$id = \dash\coding::decode($_id);
		if($id)
		{
			\lib\db\smsgroupfilter::delete($id);
			return true;
		}
		return false;
	}


	/**
	 * ready data of smsgroupfilter to load in api
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
				case 'group_id':
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