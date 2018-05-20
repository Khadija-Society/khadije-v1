<?php
namespace lib\db;

class mytransactions
{
	public static function total_paid($_where, $_today = false)
	{
		$result = 0;
		$make_where = \dash\db\config::make_where($_where);
		if($make_where)
		{
			$date = null;
			if($_today)
			{
				$date = date("Y-m-d");
				$date = "AND DATE(transactions.date) = DATE('$date') ";
			}
			$query = "SELECT sum(transactions.plus) AS `sum` FROM transactions WHERE $make_where AND verify = 1 $date";
			$result = \dash\db::get($query, 'sum', true);
		}

		return intval($result);
	}

	public static function user_transaction($_type = 'donate')
	{
		$user_id = \dash\user::id();
		if(!$user_id)
		{
			return false;
		}
		if(!$_type)
		{
			return false;
		}

		$query =
		"
			SELECT
				transactions.doners,
				transactions.date,
				transactions.plus,
				transactions.fullname
			FROM
				transactions
			WHERE
				transactions.donate  = '$_type' AND
				transactions.user_id = $user_id AND
				transactions.verify  = 1
			ORDER BY transactions.id DESC
			LIMIT 100
		";
		return \dash\db::get($query);
	}


	public static function transaction_list()
	{
		$limit = 100;
		$pagenation_query = "SELECT	COUNT(*) AS `count`	FROM `transactions` WHERE transactions.verify = 1 ";
		$pagenation_query = \dash\db::get($pagenation_query, 'count', true);
		list($limit_start, $limit) = \dash\db::pagnation((int) $pagenation_query, $limit);
		$limit = " LIMIT $limit_start, $limit ";

		$query =
		"
			SELECT
				transactions.doners,
				transactions.date,
				transactions.plus,
				transactions.fullname
			FROM
				transactions
			WHERE
				transactions.verify  = 1
			ORDER BY transactions.id DESC
			$limit
		";
		return \dash\db::get($query);
	}


}
?>
