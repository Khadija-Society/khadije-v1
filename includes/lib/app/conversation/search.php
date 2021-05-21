<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class search
{
	public static function list($_query_string, $_args)
	{
		$and        = [];
		$or         = [];
		$meta       = [];
		$order_sort = null;

		$meta['limit'] = 10;

		$order_sort = ' ORDER BY MAX(s_sms.id) DESC';

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