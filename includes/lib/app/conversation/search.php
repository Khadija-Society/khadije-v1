<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class search
{
	private static $is_filtered = false;

	public static function list($_query_string, $_args)
	{
		$and          = [];
		$or           = [];
		$meta         = [];
		$meta['join'] = [];
		$order_sort   = null;

		$meta['limit'] = 10;

		$level = 'new';



		if(isset($_args['level']) && is_string($_args['level']) && in_array($_args['level'], ['answered', 'awaiting', 'all','needlessanswer','archived','sendtosmspanel','sendbysmspanel','new','unknown','waitingtosend','inmobiledevice','sendedbymobile',]))
		{
			$level = $_args['level'];
		}

		switch ($level)
		{
			case 'all':
				// no limit. show all
				break;

			case 'answered':
				$and[] = " s_sms.receivestatus  = 'block' ";
				self::$is_filtered = true;
				break;

			case 'unknown':
			case 'awaiting':
				$meta['join'][] = " LEFT JOIN s_group ON s_sms.recommend_id = s_group.id ";
				$and[] = " s_sms.receivestatus  = 'awaiting' ";
				$and[] = " s_sms.recommend_id IS NOT NULL ";
				$and[] = " s_sms.answertext  IS NULL ";
				$and[] = " s_group.analyze = 1 ";
				self::$is_filtered = true;
				break;

			// case 'needlessanswer':
			// 	$and[] = " s_sms.receivestatus  = 'block' ";
			// 	self::$is_filtered = true;
			// 	break;

			// case 'archived':
			// 	$and[] = " s_sms.receivestatus  = 'skip' ";
			// 	self::$is_filtered = true;
			// 	break;

			// case 'sendtosmspanel':
			// 	$and[] = " s_sms.receivestatus  = 'sendtopanel' ";
			// 	self::$is_filtered = true;
			// 	break;

			// case 'sendbysmspanel':
			// 	$and[] = " s_sms.sendstatus  = 'sendbypanel' ";
			// 	self::$is_filtered = true;
			// 	break;


			// case 'waitingtosend':
			// 	$and[] = " s_sms.sendstatus  = 'sendbypanel' ";
			// 	self::$is_filtered = true;
			// 	break;

			// case 'inmobiledevice':
			// 	$and[] = " s_sms.sendstatus  = 'sendtodevice' ";
			// 	self::$is_filtered = true;
			// 	break;

			// case 'sendedbymobile':
			// 	$and[] = " s_sms.sendstatus  = 'send' ";
			// 	self::$is_filtered = true;
			// 	break;

			case 'new':
			default:
				$and[] = " s_sms.receivestatus  = 'awaiting' ";
				$and[] = " s_sms.recommend_id  IS NULL ";
				$and[] = " s_sms.group_id  IS NULL ";
				$and[] = " s_sms.answertext  IS NULL ";
				self::$is_filtered = true;
				break;
		}

		if($_query_string && is_string($_query_string) && mb_strlen($_query_string) < 100)
		{
			if($isMobile = \dash\utility\filter::mobile($_query_string))
			{
				$or[] = " s_sms.fromnumber = '$isMobile' ";
			}

			$or[] = " s_sms.fromnumber LIKE '%$_query_string%' ";
			$or[] = " s_sms.text LIKE '%$_query_string%' ";

		}

		$startdate = null;
		$enddate   = null;

		if(isset($_args['startdate']) && $_args['startdate'] && is_string($_args['startdate']))
		{
			$startdate                 = $_args['startdate'];
			$get_date_url['startdate'] = $startdate;
			$startdate                 = \dash\utility\convert::to_en_number($startdate);

			if(\dash\utility\jdate::is_jalali($startdate))
			{
				$startdate = \dash\utility\jdate::to_gregorian($startdate);
			}
			\dash\data::startdateEn($startdate);
		}

		if(isset($_args['enddate']) && $_args['enddate'] && is_string($_args['enddate']))
		{
			$enddate                 = $_args['enddate'];
			$get_date_url['enddate'] = $enddate;
			$enddate                 = \dash\utility\convert::to_en_number($enddate);

			if(\dash\utility\jdate::is_jalali($enddate))
			{
				$enddate = \dash\utility\jdate::to_gregorian($enddate);
			}
			\dash\data::enddateEn($enddate);
		}


		if($startdate && $enddate)
		{
			$and[] = " DATE(s_sms.datecreated) >= DATE('$startdate') AND DATE(s_sms.datecreated) <= DATE('$enddate')  ";
		}
		elseif($startdate)
		{
			$and[] = " DATE(s_sms.datecreated) >=  DATE('$startdate') ";
		}
		elseif($enddate)
		{
			$and[] = " DATE(s_sms.datecreated) <=  DATE('$enddate') ";
		}

		$list = \lib\db\conversation\search::list($and, $or, $order_sort, $meta);

		\dash\utility\pagination::np(($list ? true : false), self::$is_filtered);

		$list = array_map(['\\dash\\app', 'fix_avatar'], $list);

		return $list;
	}



	public static function view($_query_string, $_args)
	{
		$and        = [];
		$or         = [];
		$meta       = [];
		$order_sort = null;

		$meta['limit'] = 100;

		$order_sort = ' ORDER BY s_sms.id DESC';

		if(isset($_args['fromnumber']) && is_string($_args['fromnumber']))
		{
			$and[] = " s_sms.fromnumber = '$_args[fromnumber]' ";
		}
		else
		{
			return false;
		}

		$list = \lib\db\conversation\search::list_view($and, $or, $order_sort, $meta);

		return $list;
	}
}
?>