<?php
namespace lib\db\conversation;

class search
{

	public static function list($_and = [], $_or = [], $_order_sort = null, $_meta = [])
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
			$pagination_query = "SELECT  COUNT(*) AS `count` FROM s_sms GROUP BY  s_sms.fromnumber ";
			$num_rows = \dash\db::query($pagination_query);
			if(isset($num_rows->num_rows))
			{
				$num_rows = $num_rows->num_rows;
			}
			else
			{
				$num_rows = 0;
			}


			$limit = \dash\db\mysql\tools\pagination::pagination_int($num_rows, $q['limit']);
		}


		$query =
		"
			SELECT
				s_sms.fromnumber,
				COUNT(*) AS `count`,
				NULL AS `displayname`,
				NULL AS `lastdate`,
				NULL AS `lastmessage`
			FROM
				s_sms
			$q[join]
			$q[where]
			GROUP BY
				s_sms.fromnumber
			$limit
		";

		$result = \dash\db::get($query);

		if(!is_array($result))
		{
			$result = [];
		}

		$result = array_combine(array_column($result, 'fromnumber'), $result);


		self::fill_displayname($result);
		self::fill_lastdate($result);
		self::fill_lastmessage($result);


		return $result;

	}


	private static function fromnumber($result)
	{
		$fromnumber = array_column($result, 'fromnumber');
		$fromnumber = array_filter($fromnumber);
		$fromnumber = array_values($fromnumber);
		return implode("','", $fromnumber);
	}


	private static $smsids = false;
	public static function last_sms_ids($fromnumber)
	{
		if(!$fromnumber)
		{
			return 0;
		}

		if(self::$smsids === false)
		{
			$query = "SELECT MAX(s_sms.id) AS `id` FROM s_sms WHERE s_sms.fromnumber IN ('$fromnumber') GROUP BY s_sms.fromnumber";
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


	private static function fill_displayname(&$result)
	{
		$fromnumber = self::fromnumber($result);

		if(!$fromnumber)
		{
			return;
		}

		$query =
		"
			SELECT
				users.id,
				users.displayname,
				users.avatar,
				users.mobile
			FROM
				users
			WHERE
				users.mobile IN ('$fromnumber') AND
				users.displayname IS NOT NULL

		";

		$displayname = \dash\db::get($query);


		if(!is_array($displayname) || !$displayname)
		{
			$displayname = [];
		}
		else
		{

		}

		foreach ($displayname as $key => $value)
		{
			if(isset($value['displayname']) && isset($value['mobile']))
			{
				if(isset($result[$value['mobile']]))
				{
					$result[$value['mobile']]['displayname'] = $value['displayname'];
				}
			}
		}

	}

	private static function fill_lastdate(&$result)
	{
		$fromnumber = self::fromnumber($result);
		$smsid = self::last_sms_ids($fromnumber);

		if(!$fromnumber)
		{
			return;
		}


		$query =
		"
			SELECT
				s_sms.fromnumber,
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
			if(isset($value['lastdate']) && isset($value['fromnumber']))
			{
				if(isset($result[$value['fromnumber']]))
				{
					$result[$value['fromnumber']]['lastdate'] = $value['lastdate'];
				}
			}
		}



	}

	private static function fill_lastmessage(&$result)
	{
		$fromnumber = self::fromnumber($result);
		$smsid = self::last_sms_ids($fromnumber);

		if(!$fromnumber)
		{
			return;
		}


		$query =
		"
			SELECT
				s_sms.fromnumber,
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
			if(isset($value['lastmessage']) && isset($value['fromnumber']))
			{
				if(isset($result[$value['fromnumber']]))
				{
					$result[$value['fromnumber']]['lastmessage'] = $value['lastmessage'];
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