<?php
namespace lib\db;


class karbalasetting
{
	public static function gone_group_trip()
	{
		$query =
		"
			SELECT
				travels.place,
				travels.type,
				COUNT(*) AS `count`
			FROM
				travelusers
			INNER JOIN travels ON travels.id = travelusers.travel_id
			WHERE
				travels.status = 'gone'
			GROUP BY travels.place, travels.type
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function signup_group_trip()
	{
		// all status is ('awaiting','spam','cancel','reject','review','notanswer','queue','gone','delete','admincancel','draft')
		$query =
		"
			SELECT
				travels.place,
				travels.type,

				COUNT(*) AS `count`
			FROM
				travelusers
			INNER JOIN travels ON travels.id = travelusers.travel_id
			WHERE
				travels.status NOT IN ('spam','cancel','reject','queue','draft')
			GROUP BY travels.place, travels.type

		";

		$result = \dash\db::get($query);

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

	public static function count_signup_mokeb()
	{
		$query =
		"
		SELECT
				place.city,
				COUNT(*) AS `count`
			FROM
				mokebusers
			INNER JOIN place ON place.id = mokebusers.place_id
			GROUP BY place.city
		";
		$result = \dash\db::get($query, ['city', 'count'], true);

		return $result;
	}
}
?>