<?php
namespace lib\db;

class protectionagentoccasion
{
	public static function inset_allow()
	{
		\dash\db\config::public_insert('protection_agent_occasion_allow', ...func_get_args());
	}


	public static function get_allow_occaseion($_occasion_id)
	{
		$query  =
		"
			SELECT
				*
			FROM
				protection_agent_occasion_allow
			WHERE
				protection_agent_occasion_allow.protection_occasion_id = $_occasion_id
		";
		$result = \dash\db::get($query);
		return $result;

	}


	public static function get_allow($_agent_id, $_occasion_id)
	{
		$query  =
		"
			SELECT
				*
			FROM
				protection_agent_occasion_allow
			WHERE
				protection_agent_occasion_allow.protection_occasion_id = $_occasion_id AND
				protection_agent_occasion_allow.protection_agent_id = $_agent_id
			LIMIT 1
		";
		$result = \dash\db::get($query, null, true);
		return $result;
	}

	public static function get_sms_mobile_list($_occasion_id)
	{
		$query  =
		"
			SELECT
				protection_agent_occasion_allow.id AS `id`,
				protection_agent.user_id AS `user_id`
			FROM
				protection_agent_occasion_allow
			INNER JOIN protection_agent ON protection_agent.id = protection_agent_occasion_allow.protection_agent_id
			WHERE
				protection_agent_occasion_allow.protection_occasion_id = $_occasion_id
		";
		// var_dump($query);exit();
		$result = \dash\db::get($query);
		return $result;
	}

	public static function set_datenotif($_ids, $_date)
	{
		$query  =
		"
			UPDATE
				protection_agent_occasion_allow
			SET
				protection_agent_occasion_allow.datenotif = '$_date'
			WHERE
				protection_agent_occasion_allow.id IN ($_ids)
		";
		$result = \dash\db::query($query);
		return $result;

	}


	public static function get_sms_date($_occasion_id)
	{
		$query  =
		"
			SELECT
				MAX(protection_agent_occasion_allow.datenotif) as `datenotif`
			FROM
				protection_agent_occasion_allow
			WHERE
				protection_agent_occasion_allow.protection_occasion_id = $_occasion_id
		";
		$result = \dash\db::get($query, 'datenotif', true);
		return $result;
	}


	public static function delete_allow($_id)
	{
		$query  =
		"
			DELETE

			FROM
				protection_agent_occasion_allow
			WHERE
				protection_agent_occasion_allow.id = $_id
			LIMIT 1
		";
		$result = \dash\db::query($query);
		return $result;
	}



	public static function summary($_string, $_where)
	{
		$join = null;
		if(isset($_where['join_type']) && $_where['join_type'])
		{
			$join =  ' LEFT JOIN protection_occasion_type ON protection_occasion_type.protection_occasion_id = protection_agent_occasion.protection_occasion_id ';
		}

		unset($_where['join_type']);

		$where = null;
		if($_where)
		{
			$temp = \dash\db\config::make_where($_where);
			if($temp)
			{
				$where .= " AND ". $temp;
			}
		}

		if($_string)
		{
			$where .= " AND	(protection_agent.title LIKE '%$_string%' or  protection_occasion.title LIKE '%$_string%' ) ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				SUM(IFNULL(protection_agent_occasion.total_price, 0)) as `total_price`
			FROM
				protection_agent_occasion
			LEFT JOIN protection_agent ON protection_agent.id = protection_agent_occasion.protection_agent_id
			LEFT JOIN protection_occasion ON protection_occasion.id = protection_agent_occasion.protection_occasion_id
			$join
			WHERE 1 $where

		";

		$result = \dash\db::get($query, null, true);
		return $result;
	}

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
			 	protection_agent.city AS `city`,
			 	protection_agent.province AS `province`,
			 	protection_agent.type AS `agent_type`,
			 	protection_occasion.type AS `occasion_type`,
			 	protection_occasion.title AS `occasion_title`,
			 	(SELECT COUNT(*) FROM protection_user_agent_occasion WHERE protection_agent_id = protection_agent.id AND protection_occasion_id = protection_agent_occasion.protection_occasion_id) AS `count_user`

			 ",
			'master_join' =>
			"
				LEFT JOIN protection_agent ON protection_agent.id = protection_agent_occasion.protection_agent_id
				LEFT JOIN protection_occasion ON protection_occasion.id = protection_agent_occasion.protection_occasion_id
			"
		];

		if(isset($_options['join_type']) && $_options['join_type'])
		{
			$default_option['master_join'].=  ' LEFT JOIN protection_occasion_type ON protection_occasion_type.protection_occasion_id = protection_agent_occasion.protection_occasion_id ';
		}

		unset($_options['join_type']);

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('protection_agent_occasion', $_string, $_options);

		return $result;
	}


}
?>