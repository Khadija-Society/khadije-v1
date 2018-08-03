<?php
namespace lib\db;

class festivalusers
{

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('festivalusers', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('festivalusers', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('festivalusers', ...func_get_args());
		return $result;
	}


	public static function get_full($_where)
	{
		$where = \dash\db\config::make_where($_where);
		$query =
		"
			SELECT
				festivals.title AS `festival_title`,
				festivalcourses.title AS `festivalcourse_title`,
				festivalusers.*
			FROM
				festivalusers
			INNER JOIN festivals ON festivals.id = festivalusers.festival_id
			INNER JOIN festivalcourses ON festivalcourses.id = festivalusers.festivalcourse_id
			WHERE $where
		";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search()
	{
		return \dash\db\config::public_search('festivalusers', ...func_get_args());
	}

}
?>