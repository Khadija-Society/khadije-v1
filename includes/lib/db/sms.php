<?php
namespace lib\db;


class sms
{
	private static $master_join =
	"
		LEFT JOIN s_group ON s_sms.group_id = s_group.id
		LEFT JOIN s_group as `recommendGroup` ON s_sms.recommend_id = recommendGroup.id
	";

	private static $public_show_field =
	"
		s_sms.*, s_group.title AS `group_title`, recommendGroup.title AS `recommend_title`
	";


	public static function get_last_sms($_fromnumber)
	{
		$query = "SELECT * FROM s_sms WHERE s_sms.fromnumber = '$_fromnumber' ORDER BY s_sms.id DESC LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function need_send_notif()
	{
		$query =
		"
			SELECT
				s_sms.*,
				s_group.title AS `group_title`,
				recommendGroup.title AS `recommend_title`
			FROM
				s_sms
			LEFT JOIN s_group ON s_sms.group_id = s_group.id
			LEFT JOIN s_group as `recommendGroup` ON s_sms.recommend_id = recommendGroup.id
			WHERE
				s_sms.receivestatus = 'awaiting'
			ORDER BY
				s_sms.id ASC
			LIMIT 1
		";

		$result = \dash\db::get($query, null, true);
		return $result;

	}

	public static function get_chart_receive($_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				DATE(s_sms.datecreated) AS `date`
			FROM
				s_sms
			WHERE
				DATE(s_sms.datecreated) <= DATE('$_startdate')  AND
				DATE(s_sms.datecreated) >= DATE('$_enddate')
			GROUP BY
				DATE(s_sms.datecreated)
			ORDER BY DATE(s_sms.datecreated) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);
		return $result;
	}

	public static function get_chart_send($_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				DATE(s_sms.datemodified) AS `date`
			FROM
				s_sms
			WHERE
				s_sms.answertext IS NOT NULL AND
				DATE(s_sms.datemodified) <= DATE('$_startdate')  AND
				DATE(s_sms.datemodified) >= DATE('$_enddate')
			GROUP BY
				DATE(s_sms.datemodified)
			ORDER BY DATE(s_sms.datemodified) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);
		return $result;
	}

	public static function insert()
	{
		\dash\db\config::public_insert('s_sms', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_sms', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_sms', ...func_get_args());
	}

	public static function update_where()
	{
		return \dash\db\config::public_update_where('s_sms', ...func_get_args());
	}


	public static function get($_args)
	{
		$option =
		[
			'master_join' => self::$master_join,

			'public_show_field' => self::$public_show_field,
		];

		return \dash\db\config::public_get('s_sms', $_args, $option);
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_sms', ...func_get_args());
	}


	public static function search($_string = null, $_option = [])
	{
		$default =
		[
			'search_field' => "(s_sms.text LIKE '%__string__%')",

			'master_join' => self::$master_join,

			'public_show_field' => self::$public_show_field,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);
		$result = \dash\db\config::public_search('s_sms', $_string, $_option);

		return $result;
	}


	public static function status_count($_args = [])
	{

		$where = null;
		if($_args)
		{
			unset($_args['order']);
			unset($_args['sort']);
			$where = \dash\db\config::make_where($_args);
			if($where)
			{
				$where = "WHERE $where";
			}
			else
			{
				$where = "";
			}
		}

		$master_join = self::$master_join;
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				receivestatus
			FROM
				s_sms
			$master_join
			$where
			GROUP BY
				receivestatus
		";
		$result = \dash\db::get($query);
		return $result;
	}

}
?>
