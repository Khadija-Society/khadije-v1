<?php
namespace lib\db\report;

class month
{
	public static function monthly($_sort, $_order)
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
				GROUP BY MONTH(transactions.datecreated), YEAR(transactions.datecreated)
			) AS `mycount`
		";
		$totla_rows = \dash\db::get($limit_query, 'totla_rows', true);

		list($start_limit, $end_limit) = \dash\db::pagnation(intval($totla_rows), 12);
		if($start_limit > 0)
		{
			$date_start =  date("Y-m-d", strtotime("-". (string) ($start_limit * 30). " days"));
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

		$date_end = date("Y-m-d", strtotime("-". (string) ($page * 12 * 30 )." days"));

		if($_sort === 'date')
		{
			$_sort = "YEAR(transactions.datecreated) $_order , MONTH(transactions.datecreated) $_order ";
			$_order = null;
		}
		else
		{
			$_sort = "`$_sort`";
		}

		$query =
		"
			SELECT
				MONTH(transactions.datecreated) AS `month`,
				YEAR(transactions.datecreated) AS `year`,
				SUM(transactions.plus) AS `sum`
			FROM
				transactions
			WHERE
				transactions.verify = 1 AND
				YEAR(transactions.datecreated) <= YEAR('$date_start') AND
				YEAR(transactions.datecreated) > YEAR('$date_end')

			GROUP BY MONTH(transactions.datecreated), YEAR(transactions.datecreated)
			ORDER BY $_sort $_order
		";

		$result = \dash\db::get($query);

		return $result;
	}
}
?>