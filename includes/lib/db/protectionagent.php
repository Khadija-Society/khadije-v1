<?php
namespace lib\db;

class protectionagent
{

	public static function get_detail($_id)
	{
		$query  = "SELECT protection_agent.* FROM protection_agent WHERE protection_agent.protection_agent_id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function remove_detail($_id)
	{
		$query  = "DELETE FROM  protection_agent WHERE protection_agent.id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_agentprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_agent', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function insert_detail()
	{
		\dash\db\config::public_insert('protection_agent', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_agentprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_agent', ...func_get_args());
	}


	/**
	 * get protection_agentprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_agent', ...func_get_args());
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
			'search_field'      =>" (protection_agent.title LIKE '%__string__%' OR users.mobile LIKE '%__string__%' OR protection_agent.type LIKE '%__string__%') ",
			'public_show_field' => " protection_agent.*, users.mobile ",
			'master_join' => "LEFT JOIN users ON users.id = protection_agent.user_id"
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('protection_agent', $_string, $_options);
	}


}
?>