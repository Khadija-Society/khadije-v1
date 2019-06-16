<?php
namespace lib\db;

class travelusers
{

	public static function remove($_id, $_travel_id)
	{
		$query = "DELETE FROM travelusers WHERE travelusers.id = $_id AND travelusers.travel_id = $_travel_id LIMIT 1";

		$result = \dash\db::query($query);

		return $result;
	}


	public static function get_travel_child($_travel_id)
	{
		if(!$_travel_id || !is_numeric($_travel_id))
		{
			return [];
		}

		$query =
		"
			SELECT
				users.*,
				travelusers.id AS `id`,
				travelusers.user_id AS `user_id`,
				(
					SELECT COUNT(*)
					FROM travelusers
					INNER JOIN travels ON travels.id = travelusers.travel_id
					WHERE travelusers.user_id = users.id
					AND travels.place = 'qom'
					AND travels.status = 'gone'
				) AS `qom`,
				(
					SELECT COUNT(*)
					FROM travelusers
					INNER JOIN travels ON travels.id = travelusers.travel_id
					WHERE travelusers.user_id = users.id
					AND travels.place = 'mashhad'
					AND travels.status = 'gone'
				) AS `mashhad`,
				(
					SELECT COUNT(*)
					FROM travelusers
					INNER JOIN travels ON travels.id = travelusers.travel_id
					WHERE travelusers.user_id = users.id
					AND travels.place = 'karbala'
					AND travels.status = 'gone'
				) AS `karbala`

			FROM users
			INNER JOIN travelusers ON travelusers.user_id = users.id
			LEFT JOIN nationalcodes ON nationalcodes.nationalcode = users.nationalcode
			WHERE
			travelusers.travel_id = $_travel_id
		";
		$result = \dash\db::get($query);
		// j($result);
		return $result;
	}


	public static function duplicate_nationalcode_in_child($_national_code, $_travel_id)
	{
		$query =
		"
			SELECT * FROM users
			INNER JOIN travelusers ON travelusers.user_id = users.id
			WHERE
			travelusers.travel_id = $_travel_id AND
			users.nationalcode    = $_national_code
		";

		$result = \dash\db::get($query);

		return $result;
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('travelusers', ...func_get_args());
		return \dash\db::insert_id();
	}

	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('travelusers', ...func_get_args());
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('travelusers', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('travelusers', ...func_get_args());
		return $result;
	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search()
	{
		return \dash\db\config::public_search('travelusers', ...func_get_args());
	}


	public static function get_count()
	{
		return \dash\db\config::public_get_count('travelusers', ...func_get_args());
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
			$query = "DELETE FROM travelusers WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}


	public static function make_duplicate($_new_travel_id, $_old_id)
	{

		$query =
		"
			INSERT INTO travelusers
			(
				`travel_id`,
				`user_id`,
				`status`,
				`desc`,
				`meta`
			)
			SELECT
				'$_new_travel_id',
				travelusers.user_id,
				travelusers.status,
				travelusers.desc,
				travelusers.meta
			FROM travelusers
			WHERE travelusers.travel_id = $_old_id
		";
		return \dash\db::query($query);

	}
}
?>