<?php
namespace lib\db;

class protectionagentoccasionchild
{

	public static function get_sum_capacity($_occasion_id, $_protection_agent_id)
	{
		$query  =
		"
			SELECT
				SUM(IFNULL(protection_agent_occasion_child.capacity, 0)) as `sum`
			FROM
				protection_agent_occasion_child
			WHERE
				protection_agent_occasion_child.protection_occasion_id = $_occasion_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent_occasion_child.protection_agent_id = $_protection_agent_id
		";


		$result = \dash\db::get($query, 'sum', true);

		return $result;
	}

	public static function get_detail_from_child($_occasion_id, $_user_id)
	{
		$query  =
		"
			SELECT
				protection_agent_occasion_child.*
			FROM
				protection_agent_occasion_child
			WHERE
				protection_agent_occasion_child.user_id = $_user_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent_occasion_child.protection_occasion_id = $_occasion_id
			LIMIT 1
		";


		$result = \dash\db::get($query, null, true);

		return $result;
	}


	public static function get_agent_id_from_child($_occasion_id, $_user_id)
	{
		$query  =
		"
			SELECT
				protection_agent.id
			FROM
				protection_agent_occasion_child

			INNER JOIN
				protection_agent_occasion ON
					protection_agent_occasion.protection_occasion_id = protection_agent_occasion_child.protection_occasion_id AND
					protection_agent_occasion.protection_agent_id = protection_agent_occasion_child.protection_agent_id
			INNER JOIN
				protection_agent ON
					protection_agent.id = protection_agent_occasion_child.protection_agent_id
			WHERE
				protection_agent_occasion_child.user_id = $_user_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent_occasion.protection_occasion_id = $_occasion_id
			LIMIT 1
		";


		$result = \dash\db::get($query, 'id', true);

		return $result;
	}

	public static function get_creator_id_from_child($_occasion_id, $_user_id)
	{
		$query  =
		"
			SELECT
				protection_agent_occasion_child.id as `xid`
			FROM
				protection_agent_occasion_child

			INNER JOIN
				protection_agent_occasion ON
					protection_agent_occasion.protection_occasion_id = protection_agent_occasion_child.protection_occasion_id AND
					protection_agent_occasion.protection_agent_id = protection_agent_occasion_child.protection_agent_id
			WHERE
				protection_agent_occasion_child.user_id = $_user_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent_occasion.protection_occasion_id = $_occasion_id
			LIMIT 1
		";


		$result = \dash\db::get($query, 'xid', true);

		return $result;
	}

	public static function get_detail_by_child($_id, $_user_id)
	{
		$query  =
		"
			SELECT
				protection_agent_occasion.*
			FROM
				protection_agent_occasion_child
			INNER JOIN protection_agent_occasion ON protection_agent_occasion.protection_occasion_id = protection_agent_occasion_child.protection_occasion_id AND protection_agent_occasion.protection_agent_id = protection_agent_occasion_child.protection_agent_id
			WHERE
				protection_agent_occasion_child.user_id = $_user_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent_occasion.id = $_id
			LIMIT 1
		";

		$result = \dash\db::get($query, null, true);

		return $result;
	}

	public static function remove($_id)
	{
		$query  = "DELETE FROM  protection_agent_occasion_child WHERE protection_agent_occasion_child.id = $_id LIMIT 1";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function check_is_child($_user_id)
	{
		$query  =
		"
			SELECT
				protection_agent.*
			FROM
				protection_agent_occasion_child
			INNER JOIN protection_agent ON protection_agent.id = protection_agent_occasion_child.protection_agent_id
			WHERE
				protection_agent_occasion_child.user_id = $_user_id AND
				protection_agent_occasion_child.status = 'enable' AND
				protection_agent.status = 'enable'
			LIMIT 1
		";
		$result = \dash\db::get($query, null, true);
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