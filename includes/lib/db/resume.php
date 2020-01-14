<?php
namespace lib\db;


class resume
{

	public static function insert()
	{
		\dash\db\config::public_insert('agent_resume', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('agent_resume', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('agent_resume', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('agent_resume', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('agent_resume', ...func_get_args());
	}


	public static function delete($_id)
	{
		$query  = "DELETE FROM agent_resume WHERE agent_resume.id = $_id LIMIT 1";
		$result = \dash\db::query($query);
		return $result;
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

		$result = \dash\db\config::public_search('agent_resume', $_string, $_args);
		return $result;
	}

}
?>
