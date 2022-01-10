<?php
namespace lib\db;

class protectionagentoccasionchild
{


	public static function remove($_id)
	{
		$query  = "DELETE FROM  protection_agent_occasion_child WHERE protection_agent_occasion_child.id = $_id LIMIT 1";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_agent_occasion_childprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_agent_occasion_child', ...func_get_args());
		return \dash\db::insert_id();
	}



	/**
	 * update protection_agent_occasion_childprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_agent_occasion_child', ...func_get_args());
	}


	/**
	 * get protection_agent_occasion_childprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_agent_occasion_child', ...func_get_args());
		return $result;
	}



}
?>