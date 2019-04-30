<?php
namespace lib\db;


class smsgroupfilter
{

	public static function insert()
	{
		\dash\db\config::public_insert('s_groupfilter', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_groupfilter', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_groupfilter', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('s_groupfilter', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_groupfilter', ...func_get_args());
	}

	public static function delete($_id)
	{
		return \dash\db::query("DELETE FROM s_groupfilter WHERE s_groupfilter.id = $_id LIMIT 1");
	}


	public static function search()
	{
		$result = \dash\db\config::public_search('s_groupfilter', ...func_get_args());
		return $result;
	}

}
?>
