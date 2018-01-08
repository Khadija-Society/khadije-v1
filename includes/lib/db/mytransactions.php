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
				users.firstname,
				users.lastname,
				users.gender
			FROM
				transactions
			INNER JOIN users ON users.id = transactions.user_id
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
		$query =
		"
			SELECT
				transactions.doners,
				transactions.date,
				transactions.plus,
				users.firstname,
				users.lastname,
				users.gender
			FROM
				transactions
			INNER JOIN users ON users.id = transactions.user_id
			WHERE
				transactions.verify  = 1
			ORDER BY transactions.id DESC
			LIMIT 1000

		";
		return \lib\db::get($query);
	}


}
?>
