<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class search
{
	private static $is_filtered = false;


	public static function load_current_user($_list)
	{
		$result = \lib\db\conversation\search::load_current_user($_list);

		$result = array_values($result);

		$new_result                = [];
		$new_result['user_id']     = a($result, 0, 'user_id');
		$new_result['user_code']   = \dash\coding::encode($new_result['user_id']);
		$new_result['displayname'] = a($result, 0, 'displayname');
		$new_result['mobile']      = a($result, 0, 'fromnumber');
		$new_result['avatar']      = a($result, 0, 'avatar');
		$new_result['gender']      = a($result, 0, 'gender');

		$new_result = \dash\app::fix_avatar($new_result);

		return $new_result;
	}


	public static function list($_query_string, $_args)
	{
		$and          = [];
		$or           = [];
		$meta         = [];
		$meta['join'] = [];
		$order_sort   = null;

		$meta['limit'] = 50;


		if(isset($_args['group_id']) && is_string($_args['group_id']))
		{
			$group_id = $_args['group_id'];
			$group_id = \dash\coding::decode($group_id);
			if($group_id)
			{
				$and['group_id'] = " s_sms.group_id = $group_id ";
			}
		}
		elseif (a($_args, 'group_id') === false)
		{
			$and['group_id'] = " s_sms.group_id IS NULL ";
		}


		$level = null;



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
				$and[] = " s_sms.conversation_answered  = 1 ";
				self::$is_filtered = true;
				break;



			// case 'unknown':
			// 	$meta['join'][] = " LEFT JOIN s_group ON s_sms.recommend_id = s_group.id ";
			// 	$and[] = " s_sms.receivestatus  = 'awaiting' ";
			// 	$and[] = " s_sms.recommend_id IS NOT NULL ";
			// 	$and[] = " s_sms.answertext  IS NULL ";
			// 	$and[] = " s_group.analyze = 1 ";
			// 	self::$is_filtered = true;
			// 	break;

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
			// case 'awaiting':
				$and[] = " s_sms.receivestatus  = 'awaiting' ";
				$and[] = " s_sms.recommend_id  IS NULL ";
				$and[] = " s_sms.group_id  IS NULL ";
				$and[] = " s_sms.answertext  IS NULL ";
				$and[] = " s_sms.conversation_answered  IS NULL ";
				self::$is_filtered = true;
				break;

			default:
			case 'awaiting':
				// $and[] = " s_sms.conversation_answered  IS NULL AND s_sms.answertext IS NULL ";
				$and[] = " s_sms.conversation_answered IS NULL ";
				self::$is_filtered = true;
				break;
		}

		$search_in_text = false;

		if($_query_string && is_string($_query_string) && mb_strlen($_query_string) < 100)
		{
			if($isMobile = \dash\utility\filter::mobile($_query_string))
			{
				$or[] = " s_sms.fromnumber = '$isMobile' ";
			}
			else
			{
				// \dash\notif::warn(T_('Only mobile can be search'));
				// $or[] = " s_sms.text LIKE '%$_query_string%' ";
				$or[] = " MATCH (s_sms.text) against ('%$_query_string%' IN boolean mode) ";
				// $or[] = " MATCH (s_sms.text) against ('%$_query_string%'  WITH QUERY EXPANSION) ";

				// $search_in_text = true;
			}



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
			$and[] = " s_sms.datecreated >= '$startdate 00:00:00' AND s_sms.datecreated <= '$enddate 23:59:59'  ";
		}
		elseif($startdate)
		{
			$and[] = " s_sms.datecreated >=  '$startdate 00:00:00' ";
		}
		elseif($enddate)
		{
			$and[] = " s_sms.datecreated <=  '$enddate 23:59:59' ";
		}

		if(isset($_args['get_count_all']) && $_args['get_count_all'])
		{
			$meta['get_count_all'] = true;
		}

		$list = \lib\db\conversation\search::list($and, $or, $order_sort, $meta, $search_in_text);

		if(isset($_args['get_count_all']) && $_args['get_count_all'])
		{
			return $list;
		}

		unset($and['group_id']);
		$count_group_by = \lib\db\conversation\search::count_group_by_group_id($and, $or, $order_sort, $meta, $search_in_text);
		\dash\temp::set('currentStatInGroup', $count_group_by);


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