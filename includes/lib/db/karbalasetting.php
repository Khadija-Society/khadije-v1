<?php
namespace lib\db;


class karbalasetting
{
	public static function gone_group_trip()
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				travelusers
			INNER JOIN travels ON travels.id = travelusers.travel_id
			WHERE
				travels.place = 'karbala' AND
				travels.status = 'gone'
		";

		$result = \dash\db::get($query, 'count', true);

		return $result;
	}

	public static function signup_group_trip()
	{
		// all status is ('awaiting','spam','cancel','reject','review','notanswer','queue','gone','delete','admincancel','draft')
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				travelusers
			INNER JOIN travels ON travels.id = travelusers.travel_id
			WHERE
				travels.place = 'karbala' AND
				travels.status NOT IN ('spam','cancel','reject','queue','gone','draft')
		";

		$result = \dash\db::get($query, 'count', true);

		return $result;
	}


	public static function count_signup_samtekhoda()
	{
		$query = "SELECT COUNT(*) AS `count` FROM  karbalausers";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}


	public static function count_signup_koyemohebbat()
	{
		$query = "SELECT COUNT(*) AS `count` FROM  karbala2users";
		$result = \dash\db::get($query, 'count', true);
		return $result;
	}
}
?>