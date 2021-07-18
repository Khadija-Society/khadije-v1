<?php
namespace lib\db;


class sms
{
	private static $master_join =
	"
		LEFT JOIN s_group ON s_sms.recommend_id = s_group.id
	";

	private static $public_show_field =
	"
		s_sms.*,
		(SELECT recommendGroup1.title FROM s_group AS `recommendGroup1` WHERE recommendGroup1.id = s_sms.group_id LIMIT 1) AS `group_title`,
		(SELECT recommendGroup2.type FROM s_group AS `recommendGroup2` WHERE recommendGroup2.id = s_sms.group_id LIMIT 1) AS `group_type`,
		(SELECT recommendGroup.title FROM s_group AS `recommendGroup` WHERE recommendGroup.id = s_sms.recommend_id LIMIT 1) AS `recommend_title`
	";



	public static function export_mobile($_startdate, $_enddate, $_q, $_only_mobile, $_mobile, $_platoon)
	{
		$start = null;
		if($_startdate)
		{
			$start = "AND s_sms.datecreated >= '$_startdate' ";
		}

		$end = null;
		if($_enddate)
		{
			$end = "AND s_sms.datecreated <= '$_enddate' ";
		}

		$text = null;
		$DISTINCT = 'DISTINCT';
		if(!$_only_mobile)
		{
			$DISTINCT = null;
			$text     = ', s_sms.text ';
		}

		$q = null;
		if($_q)
		{
			$q = \dash\safe::forQueryString($_q);
			$q = " AND (s_sms.text LIKE '%$q%')";
		}

		if($_mobile)
		{
			$q.= " AND (s_sms.fromnumber = '$_mobile')";
		}

		$q .= " AND s_sms.platoon = '$_platoon' ";

		$where_query = " FROM s_sms WHERE s_sms.receivestatus != 'block' $start $end $q ";

		$count_query = "SELECT COUNT(*) AS `count` $where_query ";

		$count = intval(\dash\db::get($count_query, 'count', true));

		// if(!$_only_mobile)
		// {
		// 	if($count > 10000)
		// 	{
		// 		\dash\notif::error("در این خروجی تعداد ". \dash\utility\human::fitNumber($count)." پیام یافت شد که بیشتر از حد مجاز برای خروجی است. لطفا تاریخ را محدود کنید تا حد اکثر تعداد پیام‌های خروجی به ۱۰،۰۰۰ برسد.");
		// 		return false;
		// 	}
		// }
		// else
		// {
		// }

		if($count > 20000)
		{
			\dash\notif::error("در این خروجی تعداد ". \dash\utility\human::fitNumber($count)." پیام یافت شد که بیشتر از حد مجاز برای خروجی است. لطفا تاریخ را محدود کنید تا حد اکثر تعداد پیام‌های خروجی به ۲۰،۰۰۰ برسد.");
			return false;
		}

		$query = " SELECT $DISTINCT s_sms.fromnumber AS `mobile` $text $where_query ";

		$result = \dash\db::get($query);

		\dash\notif::info(' تعداد پیام‌های خروجی گرفته شده '. \dash\utility\human::fitNumber($count));

		return $result;
	}



	public static function count_shenasaee_shode($_where = null)
	{
		$q = null;
		if($_where)
		{
			$q = ' AND '. \dash\db\config::make_where($_where);
		}
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				s_sms
			INNER JOIN s_group ON s_group.id = s_sms.recommend_id
			WHERE
				s_sms.recommend_id IS NOT NULL AND
				s_group.analyze = 1 AND
				s_sms.answertext IS NULL AND
				s_sms.receivestatus = 'awaiting'
				$q
				-- shenasaee_shode
		";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}



	public static function count_shenasaee_nashode($_where = null)
	{
		$q = null;
		if($_where)
		{
			$q = ' AND '. \dash\db\config::make_where($_where);
		}
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				s_sms
			WHERE
				s_sms.recommend_id IS NULL AND
				s_sms.group_id IS NULL AND
				s_sms.answertext IS NULL AND
				s_sms.receivestatus = 'awaiting'
				$q
				 -- shenasaee_nashode
		";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}






	public static function get_groupby_send($_gateway, $_platoon)
	{
		$q = null;
		if($_gateway)
		{
			$q = "AND s_sms.togateway = '$_gateway' ";
		}
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.sendstatus
			FROM
				s_sms
			WHERE
				s_sms.platoon = '$_platoon'
			$q
			GROUP BY s_sms.sendstatus
		";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function get_groupby_receive($_gateway, $_platoon)
	{
		$q = null;
		if($_gateway)
		{
			$q = "AND s_sms.togateway = '$_gateway' ";
		}
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.receivestatus
			FROM
				s_sms
			WHERE s_sms.platoon = '$_platoon'
			$q
			GROUP BY s_sms.receivestatus
		";
		$result = \dash\db::get($query);
		return $result;
	}



	public static function analyze_word($_words, $_not_words, $_platoon)
	{
		$words = implode("%' OR s_sms.text LIKE '%", $_words);
		$notwords = implode("%' OR s_sms.text NOT LIKE '%", $_not_words);
		$query =
		"
			SELECT
				s_sms.id
			FROM
				s_sms
			WHERE
				s_sms.sendstatus IS NULL AND
				s_sms.group_id IS NULL AND
				s_sms.platoon = '$_platoon' AND
				s_sms.answertext IS NULL AND
				(s_sms.text LIKE '%$words%')
				AND
				(s_sms.text NOT LIKE '%$notwords%')
		";

		$result = \dash\db::get($query, 'id');
		return $result;

	}

	public static function get_count_gateway_send($_date, $_gateway, $_platoon)
	{
		$from = $_date . ' 00:00:00';
		$to   = $_date . ' 23:59:59';

		$query  =
		"
			SELECT
				SUM(CEIL(s_sms.answertextcount / 70)) AS `sum`
			FROM
				s_sms
			WHERE
				s_sms.platoon = '$_platoon' AND
				s_sms.sendstatus = 'send' AND
				s_sms.datesend >= '$from' AND
				s_sms.datesend <= '$to'
		";

		$result = \dash\db::get($query, 'sum', true);
		return $result;
	}

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
				s_sms.sendstatus = 'waitingtoautosend'
		";

		$result = \dash\db::query($query);
		return $result;
	}


	public static function get_sms_panel_not_send()
	{
		$query  = "SELECT * FROM s_sms WHERE s_sms.receivestatus = 'sendtopanel' AND s_sms.sendstatus = 'awaiting' LIMIT 30";
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
			LEFT JOIN s_group ON s_sms.recommend_id = s_group.id
			WHERE s_sms.recommend_id IS NOT NULL AND s_sms.receivestatus = 'awaiting' AND s_sms.sendstatus IS NULL $where
			GROUP BY s_sms.recommend_id
		";

		$result = \dash\db::get($query);
		return $result;
	}







	public static function get_count_answerd_in_time($_fromnumber, $_date, $_platoon)
	{
		$query = "SELECT COUNT(*) AS `count` FROM s_sms WHERE s_sms.fromnumber = '$_fromnumber' AND s_sms.platoon = '$_platoon' AND s_sms.datecreated > '$_date' AND s_sms.answertext IS NOT NULL ";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}



	public static function get_last_sms($_fromnumber, $_platoon)
	{
		$query = "SELECT * FROM s_sms WHERE s_sms.fromnumber = '$_fromnumber' AND s_sms.platoon = '$_platoon' ORDER BY s_sms.id DESC LIMIT 1";
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

	public static function get_chart_receive($_platoon, $_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				DATE(s_sms.datecreated) AS `date`
			FROM
				s_sms
			WHERE
				s_sms.platoon = '$_platoon' AND
				s_sms.datecreated <= '$_startdate'  AND
				s_sms.datecreated >= '$_enddate'
			GROUP BY
				DATE(s_sms.datecreated)
			ORDER BY DATE(s_sms.datecreated) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);
		return $result;
	}

	public static function get_chart_send($_platoon, $_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				SUM(CEIL(s_sms.answertextcount / 70)) AS `count`,
				DATE(s_sms.datesend) AS `date`
			FROM
				s_sms
			WHERE
				s_sms.platoon = '$_platoon' AND
				s_sms.sendstatus = 'send' AND
				s_sms.datesend IS NOT NULL AND
				s_sms.datesend <= '$_startdate'  AND
				s_sms.datesend >= '$_enddate'
			GROUP BY
				DATE(s_sms.datesend)
			ORDER BY DATE(s_sms.datesend) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);

		return $result;
	}

	public static function get_chart_send_panel($_platoon, $_startdate, $_enddate)
	{
		$query  =
		"
			SELECT
				SUM(CEIL(s_sms.answertextcount / 70)) AS `count`,
				DATE(s_sms.date) AS `date`
			FROM
				s_sms
			WHERE
				s_sms.platoon = '$_platoon' AND
				s_sms.sendstatus = 'sendbypanel' AND
				s_sms.date IS NOT NULL AND
				s_sms.date <= '$_startdate'  AND
				s_sms.date >= '$_enddate'
			GROUP BY
				DATE(s_sms.date)
			ORDER BY DATE(s_sms.date) ASC
		";
		$result = \dash\db::get($query, ['date', 'count']);

		return $result;
	}

	public static function insert($_args)
	{
		$check_mobile = [];

		if(isset($_args['fromnumber']) && $_args['fromnumber'])
		{
			$check_query = "SELECT * FROM s_mobiles WHERE s_mobiles.mobile = '$_args[fromnumber]' LIMIT 1";
			$check_mobile = \dash\db::get($check_query, null, true);

			$date = date("Y-m-d H:i:s");
			$time = time();

			if(isset($check_mobile['id']))
			{
				$_args['mobile_id'] = $check_mobile['id'];
				\dash\db::query("UPDATE s_mobiles SET s_mobiles.lastsmstime = $time WHERE s_mobiles.id = $check_mobile[id] LIMIT 1 ");
			}
			else
			{
				$add_new_mobile = "INSERT IGNORE INTO s_mobiles SET s_mobiles.mobile = '$_args[fromnumber]', s_mobiles.datecreated = '$date', s_mobiles.lastsmstime = $time ";

				\dash\db::query($add_new_mobile);
				$insert_id = \dash\db::insert_id();

				if(!$insert_id)
				{
					$check_query = "SELECT * FROM s_mobiles WHERE s_mobiles.mobile = '$_args[fromnumber]' LIMIT 1";
					$check_mobile = \dash\db::get($check_query, null, true);

					if(isset($check_mobile['id']))
					{
						$_args['mobile_id'] = $check_mobile['id'];
					}
					else
					{
						\dash\log::set('canNotAddMobileINPayamres');
					}
				}
				else
				{
					$_args['mobile_id'] = $insert_id;
				}
			}
		}

		if(!a($_args, 'text'))
		{
			$_args['textisnull'] = 1;
		}

		\dash\db\config::public_insert('s_sms', $_args);

		$sms_id = \dash\db::insert_id();

		$platoon = a($_args, 'platoon');

		if(is_numeric($platoon))
		{

			// update last sms
			// update last time
			// update count
			// sest conversation sanswered to null

			$myCount = 1;

			if(mb_strlen(a($_args, 'fromnumber')) === 12)
			{
				$myCount = \dash\db::get("SELECT COUNT(*) AS `count` FROM s_sms WHERE s_sms.mobile_id = $_args[mobile_id] AND s_sms.platoon = '$platoon' AND s_sms.textisnull IS NULL ", 'count', true);
			}

			if(!is_numeric($myCount))
			{
				$myCount = 1;
			}

			$myTime = time();

			$myText = a($_args, 'text');
			// admin try to add new sms
			if(!$myText)
			{
				$myText = a($check_mobile, "platoon_{$platoon}_lasttext");
				$myTime = a($check_mobile, "platoon_{$platoon}_lastsmstime");

				if(!is_numeric($myTime))
				{
					$myTime = time();
				}
			}

			$update_mobile =
			[
				"platoon_{$platoon}"                       => 1,
				"platoon_{$platoon}_count"                 => $myCount,
				"platoon_{$platoon}_lastsmstime"           => $myTime,
				"platoon_{$platoon}_lasttext"              => $myText,
				"platoon_{$platoon}_conversation_answered" => null,
			];

			$set = \dash\db\config::make_set($update_mobile);

			\dash\db::query("UPDATE s_mobiles SET $set WHERE s_mobiles.id = $_args[mobile_id] LIMIT 1");


		}
		else
		{
			// bug . insers sms whitout platoon
		}


		return $sms_id;
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_sms', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_sms', ...func_get_args());
	}

	public static function update_multi($_args, $_ids)
	{
		$set = \dash\db\config::make_set($_args);

		$query = "UPDATE s_sms SET $set WHERE s_sms.id IN ($_ids) ";
		$result = \dash\db::query($query);

		return $result;
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
			'search_field' =>
			"
				(
					s_sms.text LIKE '%__string__%' OR
					s_sms.fromnumber LIKE '%__string__%' OR
					s_sms.tonumber LIKE '%__string__%'

				)
			",

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


	public static function get_count_sms($_platoon, $_type, $_field, $_gateway, $_bulk = false)
	{

		$to = date("Y-m-d"). ' 23:59:59';
		$from = null;
		switch ($_type)
		{
			case 'day':
				$from = date("Y-m-d"). ' 00:00:00';
				break;

			case 'week':
				$from = date("Y-m-d", strtotime("-7 day")). ' 00:00:00';
				break;

			case 'month':
				$from = date("Y-m-d", strtotime("-30 day")). ' 00:00:00';
				break;

			case 'total':
				$from = null;
				$to   = null;
				break;
		}

		$gateway = null;
		if($_gateway)
		{
			// $gateway = " AND s_sms.togateway = '$_gateway' ";
		}

		$where = null;
		if($from && $to)
		{
			if($_field === 'send')
			{
				$where = "AND s_sms.datesend >= '$from' AND s_sms.datesend <= '$to' ";
			}
			else
			{
				$where = "AND s_sms.datecreated >= '$from' AND s_sms.datecreated <= '$to' ";
			}
		}

		if($_field === 'send')
		{
			if($_bulk)
			{
				$query = "SELECT SUM(IF( s_sms.answertextcount < 70, 1, CEIL(s_sms.answertextcount / 70))) AS `count` FROM s_sms WHERE s_sms.platoon = '$_platoon' AND s_sms.sendstatus = 'send' $where $gateway";
			}
			else
			{
				$query = "SELECT COUNT(*) AS `count` FROM s_sms WHERE s_sms.platoon = '$_platoon' AND s_sms.sendstatus = 'send' $where $gateway";
			}
		}
		else
		{
			if($_bulk)
			{
				$query = "SELECT SUM(IF( s_sms.smscount < 70, 1, CEIL(s_sms.smscount / 70))) AS `count` FROM s_sms WHERE s_sms.platoon = '$_platoon'  $where $gateway";
			}
			else
			{
				$query = "SELECT COUNT(*) AS `count` FROM s_sms WHERE s_sms.platoon = '$_platoon'  $where $gateway";
			}
		}

		$result = \dash\db::get($query, 'count', true);
		return intval($result);
	}

}
?>
