<?php
namespace lib\db;

class thankyoumessage
{
	public static function list()
	{
		$lastYear = date("Y-m-d", strtotime("-365 days"));


		$query =
		"
			SELECT
				MAX(users.mobile) AS `mobile`,
				MAX(transactions.id) AS `id`,
				transactions.user_id,
				MAX(DATE(transactions.date)) AS `myDate`
			FROM
				transactions
			INNER JOIN users ON users.id = transactions.user_id
			WHERE
				transactions.verify = 1 AND
				transactions.status = 'enable' AND
				transactions.user_id IS NOT NULL AND
				transactions.donate = 'cash'


			GROUP BY transactions.user_id
			HAVING
				MAX(DATE(transactions.date)) <= DATE('$lastYear') AND
				(
					MAX(transactions.rememberdate) IS NULL OR
					MAX(DATE(transactions.rememberdate)) <= DATE('$lastYear')
				)
		";

		$result = \dash\db::get($query);

		return $result;
	}


	public static function sended($_ids)
	{
		$now  = date("Y-m-d");
		$_ids = array_filter($_ids);
		$_ids = array_unique($_ids);
		if($_ids)
		{
			$_ids = implode(',', $_ids);
			$query = "UPDATE transactions SET transactions.rememberdate = '$now' WHERE transactions.id IN ($_ids)";
			\dash\db::query($query);
		}
	}


}
