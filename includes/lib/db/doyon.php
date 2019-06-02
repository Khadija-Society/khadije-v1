<?php
namespace lib\db;


class doyon
{

	public static function insert()
	{
		return \dash\db\config::public_insert('doyon', ...func_get_args());
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('doyon', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('doyon', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('doyon', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('doyon', ...func_get_args());
	}


	public static function search()
	{
		$result = \dash\db\config::public_search('doyon', ...func_get_args());
		return $result;
	}


	public static function set_pay($_ids)
	{
		$ids   = implode(',', $_ids);
		$query = "UPDATE doyon SET doyon.status = 'pay' WHERE doyon.id IN ($ids) ";
		\dash\db::query($query);
	}

}
?>
