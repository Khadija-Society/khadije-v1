<?php
namespace lib\db;

class mytransactions
{

	public static function user_transaction($_type = 'donate')
	{
		$user_id = \lib\user::id();
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
		return \lib\db::get($query);
	}


	public static function transaction_list()
	{
		$limit = 100;
		$pagenation_query = "SELECT	COUNT(*) AS `count`	FROM `transactions` WHERE transactions.verify = 1 ";
		$pagenation_query = \lib\db::get($pagenation_query, 'count', true);
		list($limit_start, $limit) = \lib\db::pagnation((int) $pagenation_query, $limit);
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
		return \lib\db::get($query);
	}


}
?>
