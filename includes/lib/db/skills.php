<?php
namespace lib\db;


class skills
{

	public static function insert()
	{
		\dash\db\config::public_insert('agent_skills', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('agent_skills', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('agent_skills', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('agent_skills', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('agent_skills', ...func_get_args());
	}



	public static function search($_string = null, $_args = [])
	{
		$default =
		[
			'search_field' => " ( title LIKE '%__string__%') ",
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default, $_args);

		$result = \dash\db\config::public_search('agent_skills', $_string, $_args);
		return $result;
	}

}
?>
