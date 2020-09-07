<?php
namespace lib\db;

class protectionreport
{

	public static function occasion_type_count()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				IFNULL(protection_occasion.type, '$non') AS `type`
			FROM
				protection_occasion
			GROUP BY protection_occasion.type
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function occasion_type_price()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				SUM(IFNULL(protection_agent_occasion.total_price, 0)) AS `total_price`,
				IFNULL(protection_occasion.type, '$non') AS `type`
			FROM
				protection_agent_occasion
			LEFT JOIN protection_occasion ON protection_occasion.id = protection_agent_occasion.protection_occasion_id
			GROUP BY protection_occasion.type
		";

		$result = \dash\db::get($query);
		return $result;
	}


	public static function agent_type_count()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				IFNULL(protection_agent.type, '$non') AS `type`
			FROM
				protection_agent
			GROUP BY protection_agent.type
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function agent_type_price()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				SUM(IFNULL(protection_agent_occasion.total_price, 0)) AS `total_price`,
				IFNULL(protection_agent.type, '$non') AS `type`
			FROM
				protection_agent_occasion
			LEFT JOIN protection_agent ON protection_agent.id = protection_agent_occasion.protection_agent_id
			GROUP BY protection_agent.type
		";

		$result = \dash\db::get($query);
		return $result;
	}


	public static function agent_province_price()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				SUM(IFNULL(protection_agent_occasion.total_price, 0)) AS `total_price`,
				IFNULL(protection_agent.province, '$non') AS `province`
			FROM
				protection_agent_occasion
			LEFT JOIN protection_agent ON protection_agent.id = protection_agent_occasion.protection_agent_id
			GROUP BY protection_agent.province
		";

		$result = \dash\db::get($query);
		return $result;
	}

		public static function user_province()
	{
		$non = T_("Unknown");
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				IFNULL(protection_user_agent_occasion.province, '$non') AS `province`
			FROM
				protection_user_agent_occasion
			GROUP BY protection_user_agent_occasion.province
		";

		$result = \dash\db::get($query);
		return $result;
	}



}
?>