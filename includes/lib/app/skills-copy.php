<?php
namespace lib\app;

/**
 * Class for skills.
 */
class skills
{
	public static $sort_field =
	[
		'title',
		'subtitle',
		'status',
		'capacity',
		'type',
		'gender',
		'position',
		'sort',
	];


	public static function add($_args = [])
	{
		\dash\app::variable($_args);

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


		$skills_id = \lib\db\skills::insert($args);

		if(!$skills_id)
		{
			\dash\notif::error(T_("No way to insert data"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($skills_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewSkills', ['code' => $skills_id]);
			\dash\notif::ok(T_("Skills successfuly added"));
		}

		return $return;
	}


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
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('capacity')) unset($args['capacity']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('phone')) unset($args['phone']);
		if(!\dash\app::isset_request('postion')) unset($args['postion']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('zarihtype')) unset($args['zarihtype']);
		if(!\dash\app::isset_request('gender')) unset($args['gender']);
		if(!\dash\app::isset_request('file')) unset($args['file']);
		if(!\dash\app::isset_request('sort')) unset($args['sort']);


		if(!empty($args))
		{
			$update = \lib\db\skills::update($args, $id);

			$title = isset($args['title']) ? $args['title'] : T_("Skills");

			\dash\log::set('editSkills', ['code' => $id]);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":val successfully updated", ['val' => $title]));
			}
		}

		return \dash\engine\process::status();
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("skills id not set"));
			return false;
		}

		$get = \lib\db\skills::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid skills id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


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

		$result            = \lib\db\skills::search($_string, $_args);
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


	private static function check($_id = null)
	{
		$title = \dash\app::request('title');
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 300)
		{
			\dash\notif::error(T_("Please fill the title less than 300 character"), 'title');
			return false;
		}

		$subtitle = \dash\app::request('subtitle');
		if($subtitle && mb_strlen($subtitle) > 300)
		{
			\dash\notif::error(T_("Please fill the subtitle less than 300 character"), 'subtitle');
			return false;
		}

		$check_duplicate = \lib\db\skills::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				$code = \dash\coding::encode($check_duplicate['id']);
				$msg = T_("This title is already exist in your list");
				$msg .= ' <a href="'. \dash\url::this(). '/edit?id='.$code. '">'. T_("Click here to edit it"). "</a>";
				\dash\notif::error($msg, 'title');
				return false;
			}
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable','disable','suspend','broken']))
		{
			\dash\notif::error(T_("Invalid status"), 'status');
			return false;
		}

		$capacity = \dash\app::request('capacity');
		$capacity = \dash\utility\convert::to_en_number($capacity);
		if($capacity && !is_numeric($capacity))
		{
			\dash\notif::error(T_("Please set the capacity as a number"), 'capacity');
			return false;
		}

		if($capacity)
		{
			$capacity = intval($capacity);
			$capacity = abs($capacity);
		}


		if($capacity && intval($capacity) > 10)
		{
			\dash\notif::error(T_("Capacity is out of range!"), 'capacity');
			return false;
		}

		$desc    = \dash\app::request('desc');
		$address = \dash\app::request('address');
		$phone   = \dash\app::request('phone');
		$file    = \dash\app::request('file');

		$position = \dash\app::request('position');
		if($position && !in_array($position, ['static','floating','virtual','other']))
		{
			\dash\notif::error(T_("Invalid position"), 'position');
			return false;
		}

		$type = \dash\app::request('type');
		if($type && !in_array($type, ['donate skills','zarih','safebox', 'moneycount']))
		{
			\dash\notif::error(T_("Invalid type"), 'type');
			return false;
		}



		$sort = \dash\app::request('sort');
		$sort = \dash\utility\convert::to_en_number($sort);
		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Please set the sort as a number"), 'sort');
			return false;
		}

		if($sort)
		{
			$sort = intval($sort);
			$sort = abs($sort);
		}


		if($sort && intval($sort) > 1E+4)
		{
			\dash\notif::error(T_("Sort is out of range!"), 'sort');
			return false;
		}

		$zarihtype = \dash\app::request('zarihtype');
		if($type === 'zarih')
		{
			if($zarihtype && !in_array($zarihtype, ['zarih','najmekhaton zarih','panjere foolad']))
			{
				\dash\notif::error(T_("Invalid zarihtype"), 'zarihtype');
				return false;
			}
		}
		else
		{
			$zarihtype = null;
		}

		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['all','male','female']))
		{
			\dash\notif::error(T_("Invalid gender"), 'gender');
			return false;
		}

		$args              = [];


		$setting = [];

		$default_paytype = \dash\app::request('default_paytype');
		if($default_paytype)
		{
			$default_paytype = self::check_paytype($default_paytype);
			if(!$default_paytype)
			{
				return false;
			}

			$setting['default_paytype'] = $default_paytype;
		}

		$quickaccess1 = \dash\app::request('quickaccess1');
		if($quickaccess1)
		{
			$quickaccess1 = self::check_paytype($quickaccess1);
			if(!$quickaccess1)
			{
				return false;
			}

			$setting['quickaccess1'] = $quickaccess1;
		}

		$quickaccess2 = \dash\app::request('quickaccess2');
		if($quickaccess2)
		{
			$quickaccess2 = self::check_paytype($quickaccess2);
			if(!$quickaccess2)
			{
				return false;
			}

			$setting['quickaccess2'] = $quickaccess2;
		}


		$quickaccess3 = \dash\app::request('quickaccess3');
		if($quickaccess3)
		{
			$quickaccess3 = self::check_paytype($quickaccess3);
			if(!$quickaccess3)
			{
				return false;
			}

			$setting['quickaccess3'] = $quickaccess3;
		}


		if(!empty($setting))
		{
			$args['setting'] = json_encode($setting, JSON_UNESCAPED_UNICODE);
		}

		$args['title']     = $title;
		$args['subtitle']  = $subtitle;
		$args['sort']      = $sort;
		$args['status']    = $status;
		$args['capacity']  = $capacity;
		$args['desc']      = $desc;
		$args['address']   = $address;
		$args['phone']     = $phone;
		$args['position']  = $position;
		$args['type']      = $type;
		$args['zarihtype'] = $zarihtype;
		$args['gender']    = $gender;
		$args['file']      = $file;

		return $args;
	}


	private static function check_paytype($_paytype_id)
	{
		$_paytype_id = \dash\coding::decode($_paytype_id);
		if(!$_paytype_id)
		{
			\dash\notif::error(T_("Invalid paytype id"));
			return false;
		}
		$check_true = \lib\db\paytype::get(['id' => $_paytype_id, 'limit' => 1]);
		if(!isset($check_true['id']))
		{
			\dash\notif::error(T_("Invalid paytype id"));
			return false;
		}
		return $_paytype_id;
	}


	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
					if(isset($value))
					{
						$result[$key] = \dash\coding::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
					break;

				case 'setting':
					if($value)
					{
						$result[$key] = json_decode($value, true);
					}
					else
					{
						$result[$key] = $value;
					}
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