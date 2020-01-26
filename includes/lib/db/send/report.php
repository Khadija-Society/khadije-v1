<?php
namespace lib\db\send;

class report
{



	public static function chart_servant_status($_city = null)
	{
		$city = null;
		if($_city)
		{
			$city = " WHERE agent_servant.city = '$_city' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				agent_servant.job
			FROM
				agent_servant
				$city
			GROUP BY
				agent_servant.job
		";

		$result = \dash\db::get($query);

		return $result;
	}


	public static function chart_place_send($_city = null)
	{
		$city = null;
		if($_city)
		{
			$city = " WHERE agent_send.city = '$_city' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				agent_place.title AS `place`
			FROM
				agent_send
			INNER JOIN agent_place ON agent_place.id = agent_send.place_id
				$city
			GROUP BY
				agent_place.id
		";

		$result = \dash\db::get($query);

		return $result;
	}


	public static function get_chart($_startdate, $_enddate, $_city)
	{
		$city = null;
		if($_city)
		{
			$city = " AND agent_send.city = '$_city' ";
		}
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				DATE(agent_send.startdate) AS `date`
			FROM
				agent_send
			WHERE
				DATE(agent_send.startdate) <= DATE('$_startdate')  AND
				DATE(agent_send.startdate) >= DATE('$_enddate')
				$city
			GROUP BY
				DATE(agent_send.startdate)
			ORDER BY DATE(agent_send.startdate) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);

		return $result;
	}








}
?>
