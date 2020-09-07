<?php
namespace lib\db;

class occasion
{
	public static function get_active_list($_date, $_protection_agent_id)
	{
		$query  =
		"
			SELECT
				protection_occasion.*
			FROM
				protection_occasion
			INNER JOIN protection_agent_occasion_allow ON protection_agent_occasion_allow.protection_occasion_id = protection_occasion.id
			WHERE
				protection_occasion.status IN ('registring') AND
				DATE(protection_occasion.startdate) <= DATE('$_date') AND
				DATE(protection_occasion.expiredate) >= DATE('$_date') AND
				protection_agent_occasion_allow.protection_agent_id = $_protection_agent_id
		";


		$result = \dash\db::get($query);
		return $result;
	}

	public static function get_detail($_id)
	{
		$query  = "SELECT protection_occasion_detail.* FROM protection_occasion_detail WHERE protection_occasion_detail.protection_occasion_id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function remove_detail($_id)
	{
		$query  = "DELETE FROM  protection_occasion_detail WHERE protection_occasion_detail.id = $_id";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function insert_detail()
	{
		\dash\db\config::public_insert('protection_occasion_detail', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_occasion', ...func_get_args());
	}


	/**
	 * get protection_occasionprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_occasion', ...func_get_args());
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
			'public_show_field' =>
			"
				protection_occasion.*,
				(SELECT COUNT(*) FROM protection_agent_occasion WHERE protection_agent_occasion.protection_occasion_id = protection_occasion.id) AS `count_agent`,
				(SELECT COUNT(*) FROM protection_occasion_detail WHERE protection_occasion_detail.protection_occasion_id = protection_occasion.id) AS `count_item`,
				(SELECT COUNT(*) FROM protection_user_agent_occasion WHERE protection_user_agent_occasion.protection_occasion_id = protection_occasion.id) AS `count_user`
			",
			'search_field'      =>" (protection_occasion.title LIKE '%__string__%' OR protection_occasion.type LIKE '%__string__%' OR protection_occasion.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('protection_occasion', $_string, $_options);
	}


}
?>