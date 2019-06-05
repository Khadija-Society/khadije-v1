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


	public static function search($_string, $_option)
	{
		$default =
		[
			'master_join' => "LEFT JOIN users ON users.id = doyon.user_id",
			'public_show_field' => 'doyon.*, users.displayname, users.avatar, users.mobile'
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);

		$result = \dash\db\config::public_search('doyon', $_string, $_option);
		return $result;
	}


	public static function set_pay($_ids)
	{
		$ids   = implode(',', $_ids);
		$query = "UPDATE doyon SET doyon.status = 'pay' WHERE doyon.id IN ($ids) ";
		\dash\db::query($query);
	}


	public static function type_count()
	{
		$query = "SELECT doyon.type AS `type`, SUM(doyon.price) AS `count` FROM doyon WHERE doyon.status = 'pay' GROUP BY doyon.type";
		$result = \dash\db::get($query, ['type', 'count']);
		return $result;
	}

}
?>
