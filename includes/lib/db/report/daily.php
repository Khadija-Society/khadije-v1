<?php
namespace lib\db\report;

class daily
{
	public static function last_30_days($_days, $_sort, $_order)
	{
		$date_now = date("Y-m-d");

		$limit_query =
		"
			SELECT
				COUNT(`mycount`) AS `totla_rows`
			FROM
			(
				SELECT
					1 AS `mycount`
				FROM
					transactions
				WHERE
					transactions.verify = 1 AND

					DATE(transactions.datecreated) <= DATE('$date_now')
				GROUP BY DATE(transactions.datecreated)
			) AS `mycount`
		";
		$totla_rows = \dash\db::get($limit_query, 'totla_rows', true);

		list($start_limit, $end_limit) = \dash\db::pagnation(intval($totla_rows), $_days);
		if($start_limit > 0)
		{
			$date_start =  date("Y-m-d", strtotime("-$start_limit days"));
		}
		else
		{
			$date_start =  $date_now;
		}

		$page = intval(\dash\request::get('page'));

		if($page === 0 || $page < 0)
		{
			$page = 1;
		}

		$date_end = date("Y-m-d", strtotime("-". (string) ($page * $_days)." days"));

		$query =
		"
			SELECT
				DATE(transactions.datecreated) AS `date`,
				SUM(transactions.plus) AS `sum`
			FROM
				transactions
			WHERE
				transactions.verify = 1 AND

				(
					DATE(transactions.datecreated) <= DATE('$date_start') AND
					DATE(transactions.datecreated) > DATE('$date_end')

				)
			GROUP BY DATE(transactions.datecreated)
			ORDER BY `$_sort` $_order
		";

		$result = \dash\db::get($query, ['date', 'sum']);
		return $result;
	}
}
?>