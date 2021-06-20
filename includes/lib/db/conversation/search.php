<?php
namespace lib\db\conversation;

class search
{
	public static function load_current_user($_list)
	{
		$_list = array_combine(array_column($_list, 'mobile_id'), $_list);
		self::fill_displayname($_list);
		return $_list;
	}

	public static function count_group_by_group_id($_and = [], $_or = [], $_order_sort = null, $_meta = [])
	{
		$q      = \dash\db\config::ready_to_sql($_and, $_or, $_order_sort, $_meta);
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				s_sms.group_id,
				s_group.title
			FROM
				s_sms
			LEFT JOIN s_group ON s_group.id = s_sms.group_id
				$q[join]
				$q[where]
			GROUP BY s_sms.group_id
			ORDER BY s_group.sort ASC
		";
		$result = \dash\db::get($query);

		if(!is_array($result))
		{
			$result = [];
		}

		return $result;

	}



	public static function list($_and = [], $_or = [], $_order_sort = null, $_meta = [], $_search_in_text = false)
	{

		$q = \dash\db\config::ready_to_sql($_and, $_or, $_order_sort, $_meta);

		if($q['pagination'] === false)
		{
			if($q['limit'])
			{
				$limit = "LIMIT $q[limit] ";
			}
			else
			{
				$limit = "LIMIT 100 ";
			}
		}
		else
		{
			$count_query  =
			"
				SELECT
					COUNT(DISTINCT s_sms.mobile_id) AS `count`
				FROM
					s_sms
				$q[join]
				$q[where]
			";

			// $count = \dash\db::get($count_query, 'count', true);
			$limit = \dash\db\mysql\tools\pagination::pagination_np($q['limit']);
			// $limit = \dash\db\mysql\tools\pagination::pagination_query($count_query, $q['limit']);
		}




		// $view = "CREATE OR REPLACE VIEW s_sms AS SELECT * FROM s_sms ORDER BY s_sms.id DESC;";
		// \dash\db::query($view);

		$query =
		"
			SELECT
				DISTINCT s_sms.mobile_id,
				-- s_sms.id,
				-- s_sms.user_id,
				NULL AS `fromnumber`,
				0 AS `count`,
				NULL AS `displayname`,
				NULL AS `gender`,
				NULL AS `avatar`,
				s_mobiles.lastsmstime,
				NULL AS `lastmessage`
			FROM
				s_sms
			INNER JOIN s_mobiles ON s_mobiles.id = s_sms.mobile_id
			$q[join]
			$q[where]
			ORDER BY s_mobiles.lastsmstime DESC
			$limit
		";


		// $query =
		// "
		// 	SELECT
		// 		s_sms.mobile_id,
		// 		-- s_sms.id,
		// 		MAX(s_sms.id) AS `id`,
		// 		-- s_sms.user_id,
		// 		NULL AS `fromnumber`,
		// 		0 AS `count`,
		// 		NULL AS `displayname`,
		// 		NULL AS `gender`,
		// 		NULL AS `avatar`,
		// 		NULL AS `lastdate`,
		// 		NULL AS `lastmessage`
		// 	FROM
		// 		s_sms
		// 	$q[join]
		// 	$q[where]
		// 	GROUP BY s_sms.mobile_id

		// ";

		if(isset($_meta['get_count_all']) && $_meta['get_count_all'])
		{
			$count_query  =	"SELECT COUNT(DISTINCT s_sms.mobile_id) AS `count`	FROM s_sms $q[join] $q[where]";

			return \dash\db::get($count_query, 'count', true);
			// $result = \dash\db::query($count_query);

			// if(isset($result->num_rows))
			// {
			// 	return floatval($result->num_rows);
			// }
			// else
			// {
			// 	return 0;
			// }

		}

		// $query .= " ORDER BY `id` DESC $limit ";

		$result = \dash\db::get($query);



		if(!is_array($result))
		{
			$result = [];
		}

		$result = array_combine(array_column($result, 'mobile_id'), $result);

		foreach ($result as $key => $value)
		{
			$result[$key]['lastdate'] = date("Y-m-d H:i:s", $value['lastsmstime']);
		}

		self::fill_fromnumber($result);
		self::fill_user_id($result);
		self::fill_count($result);
		self::fill_displayname($result);
		// self::fill_lastdate($result);
		self::fill_lastmessage($result);


		return $result;

	}


	private static function mobile_id($result)
	{
		$mobile_id = array_column($result, 'mobile_id');
		$mobile_id = array_filter($mobile_id);
		$mobile_id = array_values($mobile_id);
		return implode(",", $mobile_id);
	}



	// private static function last_sms_ids($result)
	// {
	// 	$id = array_column($result, 'id');
	// 	$id = array_filter($id);
	// 	$id = array_values($id);
	// 	return implode(",", $id);
	// }


	private static $smsids = false;
	public static function last_sms_ids($result)
	{
		$mobile_id = array_column($result, 'mobile_id');
		$mobile_id = array_filter($mobile_id);
		$mobile_id = array_values($mobile_id);
		if(!$mobile_id)
		{
			return 0;
		}

		$mobile_id = implode(",", $mobile_id);

		if(self::$smsids === false)
		{
			$query = "SELECT MAX(s_sms.id) AS `id` FROM s_sms WHERE s_sms.mobile_id IN ($mobile_id) GROUP BY s_sms.mobile_id";
			$result = \dash\db::get($query, 'id');
			if(!is_array($result))
			{
				self::$smsid = 0;
			}

			$result = array_map('floatval', $result);

			self::$smsids = implode(',', $result);
		}

		return self::$smsids;
	}


	private static function fill_fromnumber(&$result)
	{
		$mobile_id = self::mobile_id($result);

		if(!$mobile_id)
		{
			return;
		}

		$query = " SELECT *	FROM s_mobiles	WHERE s_mobiles.id IN ($mobile_id) ";

		$fromnumber = \dash\db::get($query);

		if(!is_array($fromnumber) || !$fromnumber)
		{
			return;
		}

		foreach ($fromnumber as $key => $value)
		{
			if(isset($value['mobile']))
			{
				if(isset($result[$value['id']]))
				{
					$result[$value['id']]['fromnumber'] = $value['mobile'];
				}
			}
		}

	}


	private static function fill_user_id(&$result)
	{
		$mobile_id = self::mobile_id($result);

		if(!$mobile_id)
		{
			return;
		}

		$last_sms_ids = self::last_sms_ids($result);

		$query = " SELECT s_sms.user_id, s_sms.mobile_id, s_sms.id	FROM s_sms	WHERE s_sms.id IN ($last_sms_ids) ";

		$user_id = \dash\db::get($query);

		if(!is_array($user_id) || !$user_id)
		{
			return;
		}

		foreach ($user_id as $key => $value)
		{
			if(isset($result[$value['mobile_id']]))
			{
				$result[$value['mobile_id']]['user_id'] = $value['user_id'];
				$result[$value['mobile_id']]['id'] = $value['id'];
			}
		}

	}



	private static function fill_count(&$result)
	{
		$mobile_id = self::mobile_id($result);

		if(!$mobile_id)
		{
			return;
		}

		$query = " SELECT s_sms.mobile_id,	COUNT(*) AS `count` 	FROM	s_sms	WHERE	s_sms.mobile_id IN ($mobile_id)	GROUP BY s_sms.mobile_id ";

		$count = \dash\db::get($query);

		if(!is_array($count) || !$count)
		{
			return;
		}


		foreach ($count as $key => $value)
		{
			if(isset($result[$value['mobile_id']]))
			{
				$result[$value['mobile_id']]['count'] = $value['count'];
			}
		}

	}


	public static function get_one_user_displayname($_mobile)
	{
		$user_detail = \dash\db\users::get_by_mobile($_mobile);
		if(isset($user_detail['id']))
		{
			if(isset($user_detail['displayname']) && $user_detail['displayname'])
			{
				return $user_detail['displayname'];
			}

			$user_id = $user_detail['id'];
		}
		else
		{
			return null;
		}

		$result   = [];
		$result[] = ['user_id' => $user_id, 'mobile' => $_mobile, 'fromnumber' => $_mobile];

		self::fill_displayname($result);

		if(isset($result[0]['displayname']))
		{
			return $result[0]['displayname'];
		}

		return null;
	}


	private static function fill_displayname(&$result)
	{

		$user_id = array_column($result, 'user_id');
		$user_id = array_filter($user_id);
		$user_id = array_values($user_id);
		$user_id = implode(",", $user_id);


		if(!$user_id)
		{
			return;
		}

		$query =
		"
			SELECT
				users.id,
				users.displayname,
				users.avatar,
				users.gender,
				users.mobile
			FROM
				users
			WHERE
				users.id IN ($user_id) AND
				users.displayname IS NOT NULL

		";

		$displayname = \dash\db::get($query);


		if(!is_array($displayname) || !$displayname)
		{
			$displayname = [];
		}


		$displayname = array_combine(array_column($displayname, 'id'), $displayname);

		$all_id = array_column($result, 'user_id');

		foreach ($result as $key => $value)
		{
			if(isset($value['user_id']))
			{
				if(isset($displayname[$value['user_id']]['displayname']) && $displayname[$value['user_id']]['displayname'])
				{
					unset($all_id[array_search($value['user_id'], $all_id)]);

					$result[$key]['displayname'] = $displayname[$value['user_id']]['displayname'];
				}

				if(isset($displayname[$value['user_id']]['avatar']))
				{
					$result[$key]['avatar'] = $displayname[$value['user_id']]['avatar'];
				}
			}
		}

		$all_id = array_filter($all_id);

		if(!$all_id)
		{
			return;
		}

		// protection_user_agent_occasion.displayname -> user_id
		$query =
		"
			SELECT
				protection_user_agent_occasion.user_id,
				protection_user_agent_occasion.displayname
			FROM
				protection_user_agent_occasion
			WHERE
				protection_user_agent_occasion.user_id IN ($user_id) AND
				protection_user_agent_occasion.displayname IS NOT NULL

		";

		$displayname = \dash\db::get($query);


		if(!is_array($displayname) || !$displayname)
		{
			$displayname = [];
		}


		$displayname = array_combine(array_column($displayname, 'user_id'), $displayname);

		foreach ($result as $key => $value)
		{
			if(isset($value['user_id']))
			{
				if(isset($displayname[$value['user_id']]['displayname']) && $displayname[$value['user_id']]['displayname'])
				{
					unset($all_id[array_search($value['user_id'], $all_id)]);

					$result[$key]['displayname'] = $displayname[$value['user_id']]['displayname'];
				}

				if(isset($displayname[$value['user_id']]['avatar']))
				{
					$result[$key]['avatar'] = $displayname[$value['user_id']]['avatar'];
				}
			}
		}

		$all_id = array_filter($all_id);

		if(!$all_id)
		{
			return;
		}


		$fromnumber = array_column($result, 'fromnumber');
		$fromnumber = array_filter($fromnumber);
		$fromnumber = array_values($fromnumber);
		$fromnumber = implode("','", $fromnumber);

		// karbalausers.dislayname -> mobile
		$query =
		"
			SELECT
				karbalausers.mobile,
				karbalausers.displayname
			FROM
				karbalausers
			WHERE
				karbalausers.mobile IN ('$fromnumber') AND
				karbalausers.displayname IS NOT NULL

		";

		$displayname = \dash\db::get($query);


		if(!is_array($displayname) || !$displayname)
		{
			$displayname = [];
		}


		$displayname = array_combine(array_column($displayname, 'mobile'), $displayname);

		foreach ($result as $key => $value)
		{
			if(isset($value['fromnumber']))
			{
				if(isset($displayname[$value['fromnumber']]['displayname']) && $displayname[$value['fromnumber']]['displayname'])
				{

					unset($all_id[array_search($value['mobile_id'], $all_id)]);

					$result[$key]['displayname'] = $displayname[$value['fromnumber']]['displayname'];
				}

				if(isset($displayname[$value['fromnumber']]['avatar']))
				{
					$result[$key]['avatar'] = $displayname[$value['fromnumber']]['avatar'];
				}
			}
		}


		$query =
		"
			SELECT
				karbala2users.mobile,
				karbala2users.displayname
			FROM
				karbala2users
			WHERE
				karbala2users.mobile IN ('$fromnumber') AND
				karbala2users.displayname IS NOT NULL

		";

		$displayname = \dash\db::get($query);


		if(!is_array($displayname) || !$displayname)
		{
			$displayname = [];
		}


		$displayname = array_combine(array_column($displayname, 'mobile'), $displayname);

		foreach ($result as $key => $value)
		{
			if(isset($value['fromnumber']))
			{
				if(isset($displayname[$value['fromnumber']]['displayname']) && $displayname[$value['fromnumber']]['displayname'])
				{

					unset($all_id[array_search($value['mobile_id'], $all_id)]);

					$result[$key]['displayname'] = $displayname[$value['fromnumber']]['displayname'];
				}

				if(isset($displayname[$value['fromnumber']]['avatar']))
				{
					$result[$key]['avatar'] = $displayname[$value['fromnumber']]['avatar'];
				}
			}
		}


	}

	private static function fill_lastdate(&$result)
	{
		$mobile_id = self::mobile_id($result);
		$smsid = self::last_sms_ids($result);

		if(!$mobile_id)
		{
			return;
		}


		$query =
		"
			SELECT
				s_sms.mobile_id,
				s_sms.datecreated AS `lastdate`
			FROM
				s_sms
			WHERE
				s_sms.id IN
				(
					$smsid
				)
		";

		$lastdate = \dash\db::get($query);

		if(!is_array($lastdate))
		{
			$lastdate = [];
		}

		foreach ($lastdate as $key => $value)
		{
			if(isset($value['lastdate']) && isset($value['mobile_id']))
			{
				if(isset($result[$value['mobile_id']]))
				{
					$result[$value['mobile_id']]['lastdate'] = $value['lastdate'];
				}
			}
		}



	}

	private static function fill_lastmessage(&$result)
	{
		$mobile_id = self::mobile_id($result);
		$smsid = self::last_sms_ids($result);

		if(!$mobile_id)
		{
			return;
		}


		$query =
		"
			SELECT
				s_sms.mobile_id,
				s_sms.text AS `lastmessage`
			FROM
				s_sms
			WHERE
				s_sms.id IN
				(
					$smsid
				)
		";

		$lastmessage = \dash\db::get($query);

		if(!is_array($lastmessage))
		{
			$lastmessage = [];
		}

		foreach ($lastmessage as $key => $value)
		{
			if(isset($value['lastmessage']) && isset($value['mobile_id']))
			{
				if(isset($result[$value['mobile_id']]))
				{
					$result[$value['mobile_id']]['lastmessage'] = $value['lastmessage'];
				}
			}
		}
	}



	public static function list_view($_and = [], $_or = [], $_order_sort = null, $_meta = [])
	{
		$q = \dash\db\config::ready_to_sql($_and, $_or, $_order_sort, $_meta);

		if($q['pagination'] === false)
		{
			if($q['limit'])
			{
				$limit = "LIMIT $q[limit] ";
			}
			else
			{
				$limit = "LIMIT 100 ";
			}
		}
		else
		{

			$pagination_query = "SELECT  COUNT(*) AS `count` FROM s_sms $q[join] $q[where]	$q[order] ";
			$limit = \dash\db\mysql\tools\pagination::pagination_query($pagination_query, $q['limit']);
		}

		$query =
		"
			SELECT
				*
			FROM
				s_sms
			$q[join]
			$q[where]
			$q[order]
			$limit
		";

		$result = \dash\db::get($query);

		if(!is_array($result))
		{
			$result = [];
		}

		return $result;
	}


}
?>