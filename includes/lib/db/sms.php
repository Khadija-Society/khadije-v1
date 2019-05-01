<?php
namespace lib\db;


class sms
{

	public static function insert()
	{
		\dash\db\config::public_insert('s_sms', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_sms', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_sms', ...func_get_args());
	}

	public static function update_where()
	{
		return \dash\db\config::public_update_where('s_sms', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('s_sms', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_sms', ...func_get_args());
	}


	public static function search($_string = null, $_option = [])
	{
		$default =
		[
			'search_field' => "(s_sms.text LIKE '%__string__%')",

			'master_join' => "LEFT JOIN s_group ON s_sms.group_id = s_group.id",
			'public_show_field' => "s_sms.*, s_group.title AS `group_title`",
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);
		$result = \dash\db\config::public_search('s_sms', $_string, $_option);
		return $result;
	}


	public static function status_count()
	{
		$query = "SELECT COUNT(*) AS `count`, reseivestatus FROM s_sms GROUP BY reseivestatus";
		$result = \dash\db::get($query);
		return $result;
	}

}
?>
