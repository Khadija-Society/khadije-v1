<?php
namespace lib\db;

class travels
{
	public static function disable_all_trip($_city)
	{
		$query =
		"
			UPDATE
				travels
			SET travels.status = 'admincancel'
			WHERE
				travels.place  = '$_city' AND
				travels.status = 'awaiting' AND
				travels.type   = 'family'
		";
		return \dash\db::query($query);
	}

	public static function show_count_trip($_type)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				travels.place AS `place`
			FROM
				travels
			WHERE
				travels.status = 'awaiting' AND
				travels.type   = '$_type'
			GROUP BY travels.place
		";
		return \dash\db::get($query, ['place', 'count']);
	}

	public static function get_total($_where = null)
	{
		$where = \dash\db\config::make_where($_where);
		if($where)
		{
			$where = " WHERE $where";
		}
		$query = "SELECT COUNT(*) AS `count` FROM travels $where";
		return intval(\dash\db::get($query, 'count', true));
	}

	public static function get_total_today($_where = null)
	{
		$date = date("Y-m-d");

		$where = \dash\db\config::make_where($_where);
		if($where)
		{
			$where = " AND $where";
		}
		$query = "SELECT COUNT(*) AS `count` FROM travels WHERE DATE(travels.datecreated) = DATE('$date') $where";
		return intval(\dash\db::get($query, 'count', true));
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('travels', ...func_get_args());
		return \dash\db::insert_id();
	}

	public static function mulit_insert()
	{
		return \dash\db\config::public_multi_insert('travels', ...func_get_args());
	}

	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('travels', ...func_get_args());
	}


	public static function get_count()
	{
		return \dash\db\config::public_get_count('travels', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('travels', ...func_get_args());
		return $result;
	}


/**
	 * Searches for the first match.
	 *
	 * @param      <type>  $_string   The string
	 * @param      array   $_options  The options
	 */
	public static function search($_string = null, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$default_option =
		[
			'search_field'      =>
			"
				(
					users.firstname LIKE '%__string__%' OR
					users.lastname LIKE '%__string__%' OR
					users.nationalcode LIKE '%__string__%' OR
					travels.id = '__string__' OR
					travels.place = '__string__'

				)
			",
			'public_show_field' =>
			"
				(SELECT COUNT(*) FROM travels AS `qomTravel` WHERE qomTravel.user_id = travels.user_id AND qomTravel.place = 'qom' AND qomTravel.status = 'gone' ) AS `qom`,
				(SELECT COUNT(*) FROM travels AS `mashhadTravel` WHERE mashhadTravel.user_id = travels.user_id AND mashhadTravel.place = 'mashhad' AND mashhadTravel.status = 'gone' ) AS `mashhad`,
				(SELECT COUNT(*) FROM travels AS `karbalaTravel` WHERE karbalaTravel.user_id = travels.user_id AND karbalaTravel.place = 'karbala' AND karbalaTravel.status = 'gone' ) AS `karbala`,
				users.firstname      AS `firstname`,
				users.mobile         AS `mobile`,
				users.birthday       AS `birthday`,
				users.homeaddress    AS `address`,
				users.province       AS `province`,
				users.phone          AS `phone`,
				users.zipcode        AS `zipcode`,
				users.email          AS `email`,
				users.pasportdate    AS `pasportdate`,
				users.pasportcode    AS `pasportcode`,
				users.married        AS `married`,
				users.city           AS `city`,
				users.country        AS `country`,
				users.gender         AS `gender`,
				users.father         AS `father`,
				users.lastname       AS `lastname`,
				users.nationalcode   AS `nationalcode`,
				users.hawzahcode   AS `hawzahcode`,
				users.file1   AS `file1`,
				users.file2   AS `file2`,
				travels.*,
				(SELECT COUNT(*) FROM travelusers WHERE travelusers.travel_id = travels.id) AS `countpartner`
			",
			'master_join'       =>
			"
				INNER JOIN users ON users.id = travels.user_id
			",
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('travels', $_string, $_options);
		// j($result);
		return $result;
	}


	/**
	 * delete by where
	 *
	 * @param      <type>   $_where  The where
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function delete_where($_where)
	{
		$where = \dash\db\config::make_where($_where);
		if($where)
		{
			$query = "DELETE FROM travels WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}


	public static function make_duplicate($_id, $_new_place, $_meta)
	{
		$meta = [$_meta['key'] => $_meta];
		$meta = json_encode($meta, JSON_UNESCAPED_UNICODE);
		$meta = addslashes($meta);

		$query =
		"
			INSERT INTO travels
			(
				`user_id`,
				`place`,
				`hotel`,
				`countpeople`,
				`startdate`,
				`enddate`,
				`type`,
				`status`,
				`desc`,
				`meta`
			)
			SELECT
				travels.user_id,
				'$_new_place',
				travels.hotel,
				travels.countpeople,
				null,
				null,
				travels.type,
				travels.status,
				travels.desc,
				'$meta'
			FROM travels
			WHERE travels.id = $_id
			LIMIT 1
		";
		\dash\db::query($query);
		return \dash\db::insert_id();
	}
}
?>