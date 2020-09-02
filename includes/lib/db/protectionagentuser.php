<?php
namespace lib\db;

class protectionagentuser
{

	public static function get_detail($_id)
	{
		$query  = "SELECT protection_user_agent_occasion.* FROM protection_user_agent_occasion WHERE protection_user_agent_occasion.protection_user_agent_occasion_id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function remove($_id)
	{
		$query  = "DELETE FROM  protection_user_agent_occasion WHERE protection_user_agent_occasion.id = $_id LIMIT 1";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_user_agent_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_user_agent_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function insert_detail()
	{
		\dash\db\config::public_insert('protection_user_agent_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_user_agent_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_user_agent_occasion', ...func_get_args());
	}


	/**
	 * get protection_user_agent_occasionprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_user_agent_occasion', ...func_get_args());
		return $result;
	}


	public static function search($_string = null, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$default_option =
		[
			'search_field'      =>
			"
				(
					protection_user_agent_occasion.displayname LIKE '%__string__%' OR
					protection_user_agent_occasion.mobile LIKE '%__string__%' OR
					protection_user_agent_occasion.nationalcode LIKE '%__string__%' OR
					protection_agent.title LIKE '%__string__%'
				)
			",
			'public_show_field' =>
			"
				protection_user_agent_occasion.*,
				protection_agent.title AS `agent_title`,
				protection_agent.type AS `agent_type`
			",
			'master_join'       => " LEFT JOIN protection_agent ON protection_agent.id = protection_user_agent_occasion.protection_agent_id "
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('protection_user_agent_occasion', $_string, $_options);
	}


}
?>