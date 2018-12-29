<?php
namespace lib\db;

class thankyoumessage
{
	public static function list()
	{
		return false;
		$now = date("Y-m-d", strtotime("-10 days"));
		$now = date("Y-m-d");

		$query =
		"
			SELECT
				MAX(transactions.id) AS `id`,
				transactions.user_id,
				DATE(transactions.date) AS `myDate`
			FROM
				transactions
			WHERE
				transactions.verify = 1 AND
				transactions.status = 'enable' AND
				transactions.user_id IS NOT NULL AND
				transactions.donate = 'cash'

			GROUP BY transactions.user_id, DATE(transactions.date)
			ORDER BY DATE(transactions.date) DESC
			-- HAVING myDate = DATE('$now')

		";
		$result = \dash\db::get($query);
		j($result);
		return $result;
	}


}
