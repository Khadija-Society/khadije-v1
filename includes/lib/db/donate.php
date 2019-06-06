<?php
namespace lib\db;


class donate
{
	public static function check_way_opt($_way, $_wayopt)
	{
		$query =
		"
			SELECT
				needs.id
			FROM
				needs
			WHERE
				needs.type = 'donate' AND
				needs.title = '$_way' AND
				(
					needs.title1 = '$_wayopt' OR
					needs.title2 = '$_wayopt' OR
					needs.title3 = '$_wayopt'
				)
			LIMIT 1
		";

		$result = \dash\db::get($query, 'id', true);

		return $result;
	}


	public static function export($_string, $_option)
	{
		$default =
		[
			'master_join' => "LEFT JOIN users ON users.id = transactions.user_id",
			'public_show_field' =>
			'
				transactions.title,
				users.displayname,
				users.mobile,
				transactions.plus,
				transactions.minus,
				transactions.donate,
				transactions.hazinekard,
				transactions.doners,
				transactions.datecreated
			'
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);

		$result = \dash\db\config::public_search('transactions', $_string, $_option);
		return $result;
	}
}
?>