<?php
namespace lib\db;


class donate
{
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
