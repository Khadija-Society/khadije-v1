<?php
namespace lib\db;


class donate
{


	public static function total_paid_group_by_date($_where)
	{
		$where = \dash\db\config::make_where($_where);
		if(!$where)
		{
			$where = null;
		}
		else
		{
			$where = " AND ". $where;
		}

		$query =
		"
			SELECT
				SUM(transactions.plus) AS `total`,
				DATE(transactions.datecreated) as `mydate`
			FROM
				transactions
			WHERE
				transactions.verify = 1
				$where
			GROUP BY DATE(transactions.datecreated)
		";
		$result = \dash\db::get($query);

		return $result;
	}


	public static function total_paid_group_by($_where)
	{
		$where = \dash\db\config::make_where($_where);
		if(!$where)
		{
			$where = null;
		}
		else
		{
			$where = " AND ". $where;
		}

		$query =
		"
			SELECT
				SUM(transactions.plus) AS `total`,
				transactions.hazinekard
			FROM
				transactions
			WHERE
				transactions.verify = 1
				$where
			GROUP BY transactions.hazinekard
			ORDER BY `total` DESC
		";
		return \dash\db::get($query, ['hazinekard', 'total']);
	}


	public static function total_paid($_where = null)
	{
		$where = \dash\db\config::make_where($_where);
		if(!$where)
		{
			$where = null;
		}
		else
		{
			$where = " AND ". $where;
		}

		$query =
		"
			SELECT
				SUM(transactions.plus) AS `total`
			FROM
				transactions
			WHERE
				transactions.verify = 1
				$where
		";
		return \dash\db::get($query, 'total', true);
	}

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
				transactions.fullname,
				transactions.plus,
				transactions.minus,
				transactions.donate,
				transactions.niyat,
				transactions.hazinekard,
				transactions.doners,
				transactions.desc,
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
