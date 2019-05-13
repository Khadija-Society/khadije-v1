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
		s_sms.*, s_group.title AS `group_title`,s_group.type AS `group_type`, recommendGroup.title AS `recommend_title`
	";


	// change status of some sms has set on waitingtoautosend by check dateanswer is left 60 min
	public static function send_auto_answered($_date)
	{
		$query  =
		"
			UPDATE
				s_sms
			SET
				s_sms.sendstatus = 'awaiting'
			WHERE
				s_sms.sendstatus = 'waitingtoautosend' AND
				s_sms.dateanswer < '$_date'
		";

		$result = \dash\db::get($query);
		return $result;
	}


	public static function get_sms_panel_not_send()
	{
		$query  = "SELECT * FROM s_sms WHERE s_sms.receivestatus = 'sendtopanel' AND s_sms.sendstatus = 'awaiting' ";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function update_where_sender($_set, $_where)
	{
		$where = \dash\db\config::make_where($_where);
		$set   = \dash\db\config::make_set($_set);
		$query =
		"
			UPDATE s_sms
			SET $set, s_sms.fromgateway = s_sms.togateway
			WHERE $where
		";
		$result = \dash\db::query($query);
		return $result;
	}

	public static function group_by_togateway()
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.togateway
			FROM
				s_sms
			GROUP BY s_sms.togateway
		";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function get_recommend_group($_where = null)
	{
		$where = null;
		if($_where)
		{
			$where = " AND ". \dash\db\config::make_where($_where);
		}

		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				MAX(s_group.title) AS `title`,
				s_sms.recommend_id AS `id`
			FROM s_sms
			RIGHT JOIN s_group ON s_sms.recommend_id = s_group.id
			WHERE s_sms.recommend_id IS NOT NULL AND s_sms.receivestatus = 'awaiting' AND s_sms.sendstatus IS NULL $where
			GROUP BY s_sms.recommend_id
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function get_last_message_text($_fromnumber)
	{

		$query =
		"
			SELECT
				s_sms.text AS `text`,
				s_sms.answertext AS `answertext`,
				s_sms.fromnumber
			FROM
				s_sms
			WHERE
				s_sms.fromnumber IN ($_fromnumber)
			ORDER BY s_sms.id DESC


		";
		j($query);

		$result = \dash\db::get($query);
		return $result;
	}








	public static function get_chat_list()
	{
		$p_query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				s_sms
			GROUP BY
				s_sms.fromnumber
		";

		$pagination = \dash\db::pagination_query($p_query);

		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				-- (select s_sms.text FROM s_sms where s_sms.id = MAX(s_sms.id)) AS `last_msg`,
				s_sms.fromnumber
			FROM
				s_sms

			GROUP BY s_sms.fromnumber
			ORDER BY max(s_sms.id) DESC
			$pagination
		";

		$result = \dash\db::get($query);

		return $result;
	}







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
				s_sms.receivestatus = 'awaiting' AND
				s_sms.recommend_id IS NULL
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



	public static function get_raw($_args)
	{
		return \dash\db\config::public_get('s_sms', $_args);
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

	public static function count_receivestatus($_args = [])
	{
		$where = null;
		if($_args)
		{
			$where = " WHERE ". \dash\db\config::make_where($_args);
		}
		$query  = "SELECT IFNULL(COUNT(*),0) AS `count`, s_sms.receivestatus FROM s_sms $where GROUP BY s_sms.receivestatus";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function count_sendstatus($_args = [])
	{
		$where = null;
		if($_args)
		{
			$where = " WHERE ". \dash\db\config::make_where($_args);
		}
		$query  = "SELECT IFNULL(COUNT(*),0) AS `count`, s_sms.sendstatus FROM s_sms $where GROUP BY s_sms.sendstatus";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function count_recommend($_args = [])
	{
		$where = null;
		if($_args)
		{
			$where = "AND ". \dash\db\config::make_where($_args);
		}
		$query  = "SELECT IFNULL(COUNT(*),0) AS `count` FROM s_sms WHERE recommend_id IS NOT NULL AND sendstatus IS NULL $where";
		$result = \dash\db::get($query);
		return $result;
	}



	public static function status_count($_args = [], $_field)
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
				IFNULL(COUNT(*),0) AS `count`,
				$_field
			FROM
				s_sms
			$master_join
			$where
			GROUP BY
				$_field
		";
		$result = \dash\db::get($query, [$_field, 'count']);
		return $result;
	}


	public static function get_count_sms($_type, $_field, $_gateway)
	{

		$to = date("Y-m-d");
		$from = null;
		switch ($_type)
		{
			case 'day':
				$from = date("Y-m-d", strtotime("-1 day"));
				break;

			case 'week':
				$from = date("Y-m-d", strtotime("-7 day"));
				break;

			case 'month':
				$from = date("Y-m-d", strtotime("-30 day"));
				break;

			case 'total':
				$from = null;
				$to   = null;
				break;
		}

		$gateway = null;
		if($_gateway)
		{
			$gateway = " AND s_sms.togateway = '$_gateway' ";
		}

		$where = null;
		if($from && $to)
		{
			$where = "AND DATE(s_sms.datecreated) >= DATE('$from') AND DATE(s_sms.datecreated) <= DATE('$to') ";
		}

		if($_field === 'send')
		{
			$query = "SELECT COUNT(*) AS `count` FROM s_sms WHERE s_sms.sendstatus = 'send' $where $gateway";
		}
		else
		{
			$query = "SELECT COUNT(*) AS `count` FROM s_sms WHERE 1 $where $gateway";
		}

		$result = \dash\db::get($query, 'count', true);
		return intval($result);
	}

}
?>
