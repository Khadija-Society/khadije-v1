<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class search
{
	public static function list($_query_string, $_args)
	{
		$and          = [];
		$or           = [];
		$meta         = [];
		$meta['join'] = [];
		$order_sort   = null;

		$meta['limit'] = 10;

		$level = 'new';

		if(isset($_args['level']) && is_string($_args['level']) && in_array($_args['level'], ['all','needlessanswer','archived','sendtosmspanel','sendbysmspanel','new','unknown','waitingtosend','inmobiledevice','sendedbymobile',]))
		{
			$level = $_args['level'];
		}


		switch ($level)
		{
			case 'all':
				// no limit. show all
				break;

			case 'needlessanswer':
				$and[] = " s_sms.receivestatus  = 'block' ";
				break;

			case 'archived':
				$and[] = " s_sms.receivestatus  = 'skip' ";

				break;

			case 'sendtosmspanel':
				$and[] = " s_sms.receivestatus  = 'sendtopanel' ";
				break;

			case 'sendbysmspanel':
				$and[] = " s_sms.sendstatus  = 'sendbypanel' ";

				break;

			case 'unknown':
				$meta['join'][] = " LEFT JOIN s_group ON s_sms.recommend_id = s_group.id ";
				$and[] = " s_sms.receivestatus  = 'awaiting' ";
				$and[] = " s_sms.recommend_id IS NOT NULL ";
				$and[] = " s_sms.answertext  IS NULL ";
				$and[] = " s_group.analyze = 1 ";

				break;

			case 'waitingtosend':
				$and[] = " s_sms.sendstatus  = 'sendbypanel' ";
				break;

			case 'inmobiledevice':
				$and[] = " s_sms.sendstatus  = 'sendtodevice' ";
				break;

			case 'sendedbymobile':
				$and[] = " s_sms.sendstatus  = 'send' ";
				break;

			case 'new':
			default:
				$and[] = " s_sms.receivestatus  = 'awaiting' ";
				$and[] = " s_sms.recommend_id  IS NULL ";
				$and[] = " s_sms.group_id  IS NULL ";
				$and[] = " s_sms.answertext  IS NULL ";
				break;
		}


		$list = \lib\db\conversation\search::list($and, $or, $order_sort, $meta);

		return $list;
	}



	public static function view($_query_string, $_args)
	{
		$and        = [];
		$or         = [];
		$meta       = [];
		$order_sort = null;

		$meta['limit'] = 10;

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