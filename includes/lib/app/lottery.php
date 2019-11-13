<?php
namespace lib\app;

class lottery
{
	public static function check()
	{

		// `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
		// `table` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
		// `date` datetime  NULL DEFAULT NULL,
		// `countall` int(10) NULL DEFAULT NULL,
		// `win` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
		// `status` enum('enable', 'disable', 'deleted', 'publish')  NULL DEFAULT NULL,
		// `datecreated` datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,


		$title = \dash\app::request('title');
		if($title && mb_strlen($title) > 100)
		{
			\dash\notif::error(T_("Invalid title"), 'title');
			return false;
		}

		if(!$title)
		{
			\dash\notif::error(T_("Title is required"), 'title');
			return false;
		}


		$table = \dash\app::request('table');
		if($table && mb_strlen($table) > 100)
		{
			\dash\notif::error(T_("Invalid table"), 'table');
			return false;
		}


		$date = \dash\app::request('date');
		if($date && mb_strlen($date) > 100)
		{
			\dash\notif::error(T_("Invalid date"), 'date');
			return false;
		}

		$date = \dash\date::db($date);
		if($date === false)
		{
			\dash\notif::error(T_("Invalid date date of :semester"), 'date');
			return false;
		}

		$date = \dash\date::force_gregorian($date);
		$date = \dash\date::db($date);


		if(!$date)
		{
			\dash\notif::error(T_("Date is required"), 'date');
			return false;
		}

		$countall = \dash\app::request('countall');
		if($countall && !is_numeric($countall))
		{
			\dash\notif::error(T_("Invalid countall"), 'countall');
			return false;
		}

		if(!$countall)
		{
			\dash\notif::error(T_("Count is required"), 'countall');
			return false;
		}

		$countperlevel = \dash\app::request('countperlevel');
		if($countperlevel && !is_numeric($countperlevel))
		{
			\dash\notif::error(T_("Invalid countperlevel"), 'countperlevel');
			return false;
		}

		if(!$countperlevel)
		{
			\dash\notif::error(T_("Countperlevel is required"), 'countperlevel');
			return false;
		}


		$args                  = [];
		$args['title']         = $title;
		$args['table']         = $table;
		$args['date']          = $date;
		$args['countall']      = $countall;
		$args['countperlevel'] = $countperlevel;

		return $args;
	}

	public static function get_list($_table)
	{
		$result = \lib\db\lottery::get(['table' => $_table, 'status' => 'enable']);
		return $result;
	}



	public static function load_lottery($_table, $_md5, $_step)
	{
		$get =
		[
			'table'  => $_table,
			'url'    => $_md5,
			'status' => 'enable',
			'limit'  => 1,
		];

		$lottery = \lib\db\lottery::get($get);
		if(!$lottery || !is_array($lottery) || !isset($lottery['win']) || !isset($lottery['countlevel']) || !isset($lottery['countperlevel']))
		{
			return null;
		}

		\dash\temp::set('myLotteryDetail', $lottery);

		$step = null;
		$countperlevel = intval($lottery['countperlevel']);

		if($_step && is_numeric($lottery['countlevel']))
		{
			if(intval($_step) <= 0 || intval($_step) > intval($lottery['countlevel']))
			{
				return false;
			}
			$step = intval($_step);
		}

		$win = $lottery['win'];
		$win = json_decode($win, true);
		if(!is_array($win))
		{
			return null;
		}

		$ids = implode($win, ",");

		$load_user = \lib\db\karbala2users::get(['id' => [" IN ", " ($ids)"]]);

		if(!$load_user)
		{
			return false;
		}

		$result = [];
		foreach ($load_user as $key => $value)
		{
			$ok    = false;
			$run   = false;

			$start = ($step - 1) * $countperlevel;
			if(!$start)
			{
				$start = 0;
			}

			$end = $start + $countperlevel;

			$myKey = $key + 1;

			if($myKey <= $start)
			{
				$ok = true;
			}


			$status = 'none';
			if($ok)
			{
				$status = 'ok';
			}
			else
			{
				if($myKey >= $start && $myKey <= $end)
				{
					$status = 'run';
				}

			}


			$temp                 = [];
			$temp['index']        = $key + 1;
			$temp['name']         = $value['displayname'];
			$temp['mobile']       = $value['mobile'];
			$temp['id']           = substr($value['nationalcode'], 0, 3). '**'. substr($value['nationalcode'], 5);
			$temp['nationalcode'] = $value['nationalcode'];
			$temp['father']       = $value['father'];
			$temp['province']     = \dash\utility\location\provinces::get($value['province'], null, 'localname');
			$temp['city']     = \dash\utility\location\cites::get($value['city'], null, 'localname');

			$temp['status'] = $status; // run


			$result[] = $temp;
		}

		return $result;
	}


	public static function remove($_id)
	{
		if($_id && is_numeric($_id))
		{
			\lib\db\karbala2users::remove_lottery_id($_id);
			\lib\db\lottery::update(['status' => 'deleted'], $_id);
			\dash\notif::ok(T_("Data was removed"));
			return true;
		}

		return false;
	}


	public static function add($_args)
	{
		\dash\app::variable($_args);

		$args = self::check();

		if(!$args)
		{
			return false;
		}

		$args['status'] = 'enable';
		$args['url'] = md5(json_encode($args). '_'. time(). '_'. rand());

		$countlevel = 0;
		if($args['countall'] && $args['countperlevel'])
		{
			$countlevel = intval($args['countall']) / intval($args['countperlevel']);
			$countlevel = ceil($countlevel);
		}

		$args['countlevel'] = $countlevel;

		$id = \lib\db\lottery::insert($args);

		if($id)
		{
			$win = \lib\db\karbala2users::get_rand($args['countall']);
			if($win && is_array($win))
			{
				$update['win'] = json_encode($win);
				\lib\db\lottery::update($update, $id);

				\lib\db\karbala2users::update_win(implode(',', $win), $id);
			}
		}

		return $id;
	}
}
?>