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

	public static function count_group_by_group_id($_and = [], $_or = [], $_order_sort = null, $_meta = [], $_platoon)
	{
		$q      = \dash\db\config::ready_to_sql($_and, $_or, $_order_sort, $_meta);
		$query  =
		"
			SELECT
				COUNT(DISTINCT s_mobiles.id) AS `count`,
				s_sms.group_id,
				s_group.title
			FROM
				s_sms
			LEFT JOIN s_group ON s_group.id = s_sms.group_id AND s_group.platoon = '$_platoon'
			INNER JOIN s_mobiles ON s_sms.mobile_id = s_mobiles.id
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



	public static function list($_and = [], $_or = [], $_order_sort = null, $_meta = [], $_search_in_text = false, $_platoon = null)
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
			$count_query  = " SELECT COUNT(*) AS `count` FROM s_mobiles $q[join] $q[where] ";

			$limit = \dash\db\mysql\tools\pagination::pagination_np($q['limit']);

		}

		$query = " SELECT $q[fields] FROM s_mobiles $q[join] $q[where] $q[order] $limit ";

		if(isset($_meta['get_count_all']) && $_meta['get_count_all'])
		{
			$count_query  =	"SELECT COUNT(DISTINCT s_mobiles.id) AS `count`	FROM s_mobiles $q[join] $q[where]";

			return \dash\db::get($count_query, 'count', true);
		}

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

		self::fill_user_id($result, $_platoon);
		self::fill_displayname($result, $_platoon);

		return $result;

	}




	private static function fill_user_id(&$result, $_platoon)
	{
		$mobile = array_column($result, 'mobile');

		$mobile = array_filter($mobile);
		$mobile = array_unique($mobile);
		if(!$mobile)
		{
			return;
		}

		$mobile = implode("','", $mobile);

		$query = " SELECT users.id, users.mobile FROM users	WHERE users.mobile IN ('$mobile') ";

		$user_id = \dash\db::get($query);

		if(!is_array($user_id) || !$user_id)
		{
			return;
		}

		foreach ($user_id as $key => $value)
		{
			if(isset($result[$value['mobile']]))
			{
				$result[$value['mobile']]['user_id'] = $value['id'];
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
		$all_id = $user_id;
		$user_id = implode(",", $all_id);

		$all_mobile = array_column($result, 'fromnumber');
		$all_mobile = array_filter($all_mobile);
		$all_mobile = array_values($all_mobile);


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

		foreach ($result as $key => $value)
		{
			if(isset($value['user_id']))
			{
				if(isset($displayname[$value['user_id']]['mobile']) && $displayname[$value['user_id']]['mobile'])
				{
					unset($all_mobile[array_search($value['fromnumber'], $all_mobile)]);
				}

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

		$user_id = implode(',', $all_id);

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



		$fromnumber = array_filter($all_mobile);
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

					unset($all_mobile[array_search($value['fromnumber'], $all_mobile)]);

					$result[$key]['displayname'] = $displayname[$value['fromnumber']]['displayname'];
				}

				if(isset($displayname[$value['fromnumber']]['avatar']))
				{
					$result[$key]['avatar'] = $displayname[$value['fromnumber']]['avatar'];
				}
			}
		}

		$fromnumber = implode("','", $all_mobile);


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