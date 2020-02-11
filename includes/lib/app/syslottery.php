<?php
namespace lib\app;

/**
 * Class for lottery.
 */
class syslottery
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("lottery id not set"));
			return false;
		}

		$get = \lib\db\syslottery::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid lottery id"));
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
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the lottery title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 200)
		{
			\dash\notif::error(T_("Please fill the lottery title less than 200 character"), 'title');
			return false;
		}

		$check_duplicate = \lib\db\syslottery::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("Duplicate lottery title"), 'title');
				return false;
			}
		}


		$subtitle = \dash\app::request('subtitle');
		$subtitle = trim($subtitle);


		if($subtitle && mb_strlen($subtitle) > 200)
		{
			\dash\notif::error(T_("Please fill the lottery subtitle less than 200 character"), 'subtitle');
			return false;
		}

		$file = \dash\app::request('file');
		$setting = \dash\app::request('setting');
		$desc = \dash\app::request('desc');





		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable', 'disable', 'expire', 'deleted', 'done', 'draft']))
		{
			\dash\notif::error(T_("Invalid status of lottery"), 'status');
			return false;
		}




		$args             = [];

		$args['title']    = $title;
		$args['subtitle'] = $subtitle;
		$args['file']     = $file;
		$args['setting']  = $setting;
		$args['desc']     = $desc;
		$args['status']   = $status;

		return $args;
	}


	/**
	 * add new lottery
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
		$args['user_id'] = \dash\user::id();

		$lottery_id = \lib\db\syslottery::insert($args);

		if(!$lottery_id)
		{
			\dash\log::set('apiLottery:no:way:to:insertLottery');
			\dash\notif::error(T_("No way to insert lottery"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($lottery_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewLottery', ['code' => $lottery_id]);
			\dash\notif::ok(T_("Lottery successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'title',

		'status',

	];

	public static function all_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	public static function active_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'status'     => 'enable',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	/**
	 * Gets the lottery.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The lottery.
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

		$result            = \lib\db\syslottery::search($_string, $_args);
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
	 * edit a lottery
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
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);
		if(!\dash\app::isset_request('file')) unset($args['file']);
		if(!\dash\app::isset_request('setting')) unset($args['setting']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('status')) unset($args['status']);


		if(!empty($args))
		{
			$update = \lib\db\syslottery::update($args, $id);
			\dash\log::set('editLottery', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of lottery to load in api
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

				case 'setting':
					if(is_string($value))
					{
						$result['setting'] = json_decode($value, true);
					}
					else
					{
						$result[$key] = $value;
					}
					break;


				case 'file':
					if(!\dash\url::content())
					{
						if(!$value)
						{
							$value = \dash\app::static_logo_url();
						}
					}
					$result[$key] = $value;
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