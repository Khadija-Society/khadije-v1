<?php
namespace lib\db\sms;

class report
{
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
}
?>
