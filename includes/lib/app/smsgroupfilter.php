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
		'sort',
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
			if(isset($args['type']) && $args['type'] === 'number' && isset($args['group_id']))
			{
				$result = \lib\db\smsgroupfilter::have_old_record_filter($args['group_id']);
				if($result && is_array($result))
				{
					$count = count($result);
					$msg = T_("Auto update old message by new filter :val", ['val' => \dash\utility\human::fitNumber($count)]);
					$result = implode(',', $result);
					\lib\db\smsgroupfilter::update_old_record_filter($result, $args['group_id']);
					\dash\notif::info($msg);
				}
			}

			if(isset($args['type']) && $args['type'] === 'analyze' && isset($args['group_id']))
			{
				$result = self::add_new_filter($args['group_id']);
				if($result && is_array($result))
				{
					$count = count($result);
					$msg = T_("Auto update old message by new filter :val", ['val' => \dash\utility\human::fitNumber($count)]);
					$result = implode(',', $result);
					\lib\db\smsgroupfilter::update_old_record_filter($result, $args['group_id']);
					\dash\notif::info($msg);
				}
			}
			\dash\notif::ok(T_("Sms filter successfuly added"));
		}

		return $return;
	}


	private static function add_new_filter($_group_id)
	{
		$get_words = \lib\db\smsgroupfilter::get(['type' => 'analyze', 'group_id' => $_group_id]);
		$get_not_words = \lib\db\smsgroupfilter::get(['type' => 'analyze', 'group_id' => [" != ", " $_group_id " ]]);
		if(is_array($get_words) && is_array($get_not_words))
		{
			$get_words     = array_column($get_words, 'text');
			$get_not_words = array_column($get_not_words, 'text');

			$get_sms_id = \lib\db\sms::analyze_word($get_words, $get_not_words);
			if($get_sms_id)
			{
				$count = count($get_sms_id);
				$msg = T_("Auto update old message by new filter :val", ['val' => \dash\utility\human::fitNumber($count)]);
				$result = implode(',', $get_sms_id);
				\lib\db\smsgroupfilter::update_old_record_filter_recommend($result, $_group_id);
				\dash\notif::info($msg);
			}
		}

	}



	public static function sync_answer($_tag, $_id)
	{
		$group_id = \dash\coding::decode($_id);
		if(!$group_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		if(!is_string($_tag))
		{
			\dash\notif::error(T_("Invalid tag"));
			return false;
		}

		$current_list = \lib\db\smsgroupfilter::get(['group_id' => $group_id, 'type' => 'analyze',]);

		if(!is_array($current_list))
		{
			$current_list = [];
		}

		$current_list_title = array_column($current_list, 'text');
		$current_list_title = array_filter($current_list_title);
		$current_list_title = array_unique($current_list_title);

		$new_tag = explode(',', $_tag);

		$new_tag = array_filter($new_tag);
		$new_tag = array_unique($new_tag);


		$must_remove = array_diff($current_list_title, $new_tag);
		$must_insert = array_diff($new_tag, $current_list_title);

		if(!empty($must_insert))
		{
			foreach ($must_insert as $key => $value)
			{
				$check_duplicate = \lib\db\smsgroupfilter::check_duplicate_answer($value);
				if(isset($check_duplicate['id']))
				{
					\dash\notif::warn(T_("The tag :val exist in another group", ['val' => $value]));
				}
				else
				{
					$insert =
					[
						'group_id' => $group_id,
						'type' => 'analyze',
						'text' => $value,
					];

					\lib\db\smsgroupfilter::insert($insert);
				}
			}
		}

		if(!empty($must_remove))
		{
			$remove = implode("','", $must_remove);
			\lib\db\smsgroupfilter::multi_remove_analyze($remove, $group_id);
		}

		// $result = self::add_new_filter($group_id);
		// if($result && is_array($result))
		// {
		// 	$count = count($result);
		// 	$msg = T_("Auto update old message by new filter :val", ['val' => \dash\utility\human::fitNumber($count)]);
		// 	$result = implode(',', $result);
		// 	\lib\db\smsgroupfilter::update_old_record_filter($result, $group_id);
		// 	\dash\notif::info($msg);
		// }

		// \dash\notif::ok(T_("Saved"));
		return true;
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
		if(!\dash\app::isset_request('sort')) unset($args['sort']);


		if(!empty($args))
		{
			$update = \lib\db\smsgroupfilter::update($args, $id);
			\dash\notif::ok(T_("Sms filter successfully updated"));

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


		$sort = \dash\app::request('sort');
		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Invalid sort data"), 'sort');
			return false;
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
		$args['sort']  = $sort;

		return $args;
	}


	public static function set_answer_default($_id, $_group_id, $_panel = false)
	{
		$id       = \dash\coding::decode($_id);
		$group_id = \dash\coding::decode($_group_id);
		if(!$id || !$group_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$remove_all_default = \lib\db\smsgroupfilter::remove_all_default('answer', $group_id, $_panel);
		$set_default        = \lib\db\smsgroupfilter::set_default($id, $_panel);
		return $set_default;
	}


	public static function remove_answer_default($_id, $_group_id, $_panel = null)
	{
		$id       = \dash\coding::decode($_id);
		$group_id = \dash\coding::decode($_group_id);
		if(!$id || !$group_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$remove_all_default = \lib\db\smsgroupfilter::remove_all_default('answer', $group_id, $_panel);
		return $remove_all_default;
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