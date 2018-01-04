<?php
namespace lib\db;

class travelusers
{

	public static function remove($_id, $_travel_id)
	{
		$query = "DELETE FROM travelusers WHERE travelusers.id = $_id AND travelusers.travel_id = $_travel_id LIMIT 1";

		$result = \lib\db::query($query);

		return $result;
	}


	public static function get_travel_child($_travel_id)
	{
		$query =
		"
			SELECT
				users.*,
				travelusers.id AS `id`,
				travelusers.user_id AS `user_id`,
				nationalcodes.qom AS `qom`,
				nationalcodes.mashhad AS `mashhad`,
				nationalcodes.karbala AS `karbala`
			FROM users
			INNER JOIN travelusers ON travelusers.user_id = users.id
			LEFT JOIN nationalcodes ON nationalcodes.nationalcode = users.nationalcode
			WHERE
			travelusers.travel_id = $_travel_id
		";
		$result = \lib\db::get($query);
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

		$result = \lib\db::get($query);

		return $result;
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\lib\db\config::public_insert('travelusers', ...func_get_args());
		return \lib\db::insert_id();
	}

	public static function multi_insert()
	{
		return \lib\db\config::public_multi_insert('travelusers', ...func_get_args());
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('travelusers', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \lib\db\config::public_get('travelusers', ...func_get_args());
		return $result;
	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search()
	{
		return \lib\db\config::public_search('travelusers', ...func_get_args());
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
		$where = \lib\db\config::make_where($_where);
		if($where)
		{
			$query = "DELETE FROM travelusers WHERE $where";
			return \lib\db::query($query);
		}
		return false;
	}
}
?>