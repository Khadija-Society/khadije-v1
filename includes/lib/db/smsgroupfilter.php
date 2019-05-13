<?php
namespace lib\db;


class smsgroupfilter
{

	public static function remove_all_default($_type, $_group_id)
	{
		$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefault = NULL WHERE s_groupfilter.type = '$_type' AND s_groupfilter.group_id = $_group_id ";
		$result = \dash\db::query($query);
		return $result;
	}


	public static function set_default($_id)
	{
		$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefault = 1 WHERE s_groupfilter.id = $_id LIMIT 1 ";
		$result = \dash\db::query($query);
		return $result;
	}


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
