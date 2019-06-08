<?php
namespace lib\db;


class doyon
{

	public static function get_chart($_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				SUM(doyon.price) AS `sumprice`,
				DATE(doyon.datecreated) AS `date`,
				doyon.type
			FROM
				doyon
			WHERE
				DATE(doyon.datecreated) <= DATE('$_startdate')  AND
				DATE(doyon.datecreated) >= DATE('$_enddate') AND
				doyon.status = 'pay'

			GROUP BY
				DATE(doyon.datecreated), doyon.type
			ORDER BY DATE(doyon.datecreated) ASC
		";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function insert()
	{
		return \dash\db\config::public_insert('doyon', ...func_get_args());
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('doyon', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('doyon', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('doyon', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('doyon', ...func_get_args());
	}


	public static function search($_string, $_option)
	{
		$default =
		[
			'master_join' => "LEFT JOIN users ON users.id = doyon.user_id",
			'public_show_field' => 'doyon.*, users.displayname, users.avatar, users.mobile',
			'search_field' =>
			"
				(doyon.title LIKE '%__string__%')
			"
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);

		$result = \dash\db\config::public_search('doyon', $_string, $_option);
		return $result;
	}


	public static function set_pay($_ids)
	{
		$ids   = implode(',', $_ids);
		$query = "UPDATE doyon SET doyon.status = 'pay' WHERE doyon.id IN ($ids) ";
		\dash\db::query($query);
	}


	public static function type_count($_args)
	{
		$where = null;
		if($_args)
		{
			unset($_args['order']);
			unset($_args['sort']);
			if($_args)
			{

				$where = \dash\db\config::make_where($_args);
				$where = 'AND '. $where;
			}
		}

		$query = "SELECT doyon.type AS `type`, SUM(doyon.price) AS `count` FROM doyon WHERE doyon.status = 'pay' $where GROUP BY doyon.type";
		$result = \dash\db::get($query, ['type', 'count']);

		$query_fetriye = "SELECT IF(doyon.seyyed,'seyyed', 'aam') as `type` , SUM(doyon.price) AS `count` FROM doyon WHERE doyon.status = 'pay' AND doyon.type = 'fetriye' $where GROUP BY doyon.seyyed";
		$result_fetriye = \dash\db::get($query_fetriye, ['type', 'count']);

		if(isset($result_fetriye['seyyed']))
		{
			$result['fetriye_seyyed'] = $result_fetriye['seyyed'];
		}

		if(isset($result_fetriye['aam']))
		{
			$result['fetriye_aam'] = $result_fetriye['aam'];
		}

		return $result;
	}

}
?>
