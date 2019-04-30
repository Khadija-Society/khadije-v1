<?php
namespace lib\db;


class smsgroup
{

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


	public static function search()
	{
		$result = \dash\db\config::public_search('s_group', ...func_get_args());
		return $result;
	}

}
?>
