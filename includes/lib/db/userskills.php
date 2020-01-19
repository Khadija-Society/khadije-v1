<?php
namespace lib\db;


class userskills
{
	public static function insert()
	{
		\dash\db\config::public_insert('agent_userskills', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function get_user_skills($_user_id)
	{
		$query =
		"
			SELECT
				agent_skills.title,
				agent_userskills.id,
				agent_userskills.rate,
				agent_userskills.desc
			FROM agent_userskills
			INNER JOIN agent_skills ON agent_skills.id = agent_userskills.skills_id
			WHERE
				agent_userskills.user_id = $_user_id
		";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function delete($_id)
	{
		$query = "DELETE FROM agent_userskills WHERE agent_userskills.id = $_id LIMIT 1";
		$result = \dash\db::query($query);
		return $result;
	}


	public static function update()
	{
		return \dash\db\config::public_update('agent_userskills', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('agent_userskills', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('agent_userskills', ...func_get_args());
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

		$result = \dash\db\config::public_search('agent_userskills', $_string, $_args);
		return $result;
	}

}
?>
