<?php
namespace lib\db;

class protectionagentoccasion
{

	public static function report_count()
	{
		$query  =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				protection_agent_occasion
			WHERE protection_agent_occasion.report IS NOT NULL
		";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}

	public static function total_price()
	{
		$query  =
		"
			SELECT
				SUM(IFNULL(protection_agent_occasion.total_price, 0)) as `total_price`
			FROM
				protection_agent_occasion
		";
		$result = \dash\db::get($query, 'total_price', true);
		return $result;
	}


	public static function old_registered_occasion($_agent_id)
	{
		$query  =
		"
			SELECT
				protection_agent_occasion.*,
				protection_occasion.title,
				protection_occasion.subtitle
			FROM
				protection_agent_occasion
			INNER JOIN protection_occasion ON protection_occasion.id = protection_agent_occasion.protection_occasion_id
			WHERE
				protection_occasion.status IN ('registring','done','distribution') AND
				protection_agent_occasion.protection_agent_id = $_agent_id
		";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function remove_detail($_id)
	{
		$query  = "DELETE FROM  protection_agent_occasion WHERE protection_agent_occasion.id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_agent_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_agent_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function insert_detail()
	{
		\dash\db\config::public_insert('protection_agent_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_agent_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_agent_occasion', ...func_get_args());
	}


	/**
	 * get protection_agent_occasionprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_agent_occasion', ...func_get_args());
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
			'search_field'      =>" (protection_agent.title LIKE '%__string__%' or  protection_occasion.title LIKE '%__string__%' ) ",
			'public_show_field' =>
			"
			 	protection_agent_occasion.*,
			 	protection_agent.title AS `agent_title`,
			 	protection_occasion.title AS `occasion_title`,
			 	(SELECT COUNT(*) FROM protection_user_agent_occasion WHERE protection_agent_id = protection_agent.id AND protection_occasion_id = protection_agent_occasion.protection_occasion_id) AS `count_user`

			 ",
			'master_join' =>
			"
				LEFT JOIN protection_agent ON protection_agent.id = protection_agent_occasion.protection_agent_id
				LEFT JOIN protection_occasion ON protection_occasion.id = protection_agent_occasion.protection_occasion_id
			"
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('protection_agent_occasion', $_string, $_options);

		return $result;
	}


}
?>