<?php
namespace lib\db;


class smsgroup
{
	public static function list_analyze_group()
	{
		$query  = "SELECT * FROM s_group WHERE s_group.analyze = 1 AND s_group.status = 'enable' AND s_group.type = 'other' ";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function insert()
	{
		\dash\db\config::public_insert('s_group', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_group', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_group', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('s_group', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_group', ...func_get_args());
	}

	public static function search($_string = null, $_option = [])
	{
		$default =
		[
			'search_field' => "(s_group.title LIKE '%__string__%')",
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);
		$result = \dash\db\config::public_search('s_group', $_string, $_option);
		return $result;
	}



	public static function update_group_count($_id)
	{
		$query = "UPDATE s_group SET s_group.count = (SELECT COUNT(*) FROM s_sms WHERE s_sms.group_id = $_id) WHERE s_group.id = $_id LIMIT 1";
		\dash\db::query($query);
	}
}
?>
