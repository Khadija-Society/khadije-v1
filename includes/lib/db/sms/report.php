<?php
namespace lib\db\sms;

class report
{
	public static function chart_sendstatus($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " WHERE s_sms.togateway = '$_gateway' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.sendstatus
			FROM
				s_sms
				$gateway
			GROUP BY
				s_sms.sendstatus
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function chart_receivestatus($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " WHERE s_sms.togateway = '$_gateway' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.receivestatus
			FROM
				s_sms
				$gateway
			GROUP BY
				s_sms.receivestatus
		";

		$result = \dash\db::get($query);
		return $result;
	}


	public static function chart_recommend($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " WHERE s_sms.togateway = '$_gateway' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.recommend_id,
				MAX(s_group.title) AS `recommend_title`
			FROM
				s_sms
			LEFT JOIN s_group ON s_sms.recommend_id = s_group.id
				$gateway
			GROUP BY
				s_sms.recommend_id
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function chart_group($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " WHERE s_sms.togateway = '$_gateway' ";
		}

		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.group_id,
				MAX(s_group.title) AS `group_title`
			FROM
				s_sms
			LEFT JOIN s_group ON s_sms.group_id = s_group.id
				$gateway
			GROUP BY
				s_sms.group_id
		";

		$result = \dash\db::get($query);
		return $result;
	}




	public static function count_sms_day($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " AND s_sms.togateway = '$_gateway' ";
		}

		$query  =
		"
			SELECT
				SUM(CEIL(s_sms.answertextcount / 70)) AS `sms`,
				SUM(s_sms.answertextcount) AS `sum`,
				DATE(s_sms.datesend) AS `date`
			FROM
				s_sms
			WHERE
				s_sms.sendstatus = 'send' $gateway
			GROUP BY
				DATE(s_sms.datesend)
			ORDER BY
				DATE(s_sms.datesend) DESC

		";
		$result = \dash\db::get($query);

		return $result;
	}


	public static function answer_time($_gateway = null)
	{
		$gateway = null;
		if($_gateway)
		{
			$gateway = " AND s_sms.togateway = '$_gateway' ";
		}

		$query  = "SELECT AVG(TIMESTAMPDIFF(SECOND,s_sms.datecreated, s_sms.dateanswer)) AS `average` FROM s_sms WHERE  s_sms.dateanswer IS NOT NULL $gateway ";
		$result = \dash\db::get($query, 'average', true);
		return $result;
	}
}
?>
