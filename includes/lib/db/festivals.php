<?php
namespace lib\db;

class festivals
{

	public static function chart($_festival_id)
	{
		if(!$_festival_id || !is_numeric($_festival_id))
		{
			return false;
		}

		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				festivalcourses.title AS `course`
			FROM
				festivalusers
			INNER JOIN 	festivalcourses ON festivalcourses.id = festivalusers.festivalcourse_id

			WHERE
				festivalusers.festival_id =  $_festival_id

			GROUP BY festivalcourses.title

		";

		$result = \dash\db::get($query, ['course', 'count']);
		$new = [];
		foreach ($result as $key => $value)
		{
			$new[] = ['key' => $key, 'value' => $value];
		}
		$result = json_encode($new, JSON_UNESCAPED_UNICODE);
		return $result;


	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('festivals', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('festivals', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('festivals', ...func_get_args());
		return $result;
	}


	public static function group_list($_festival_id)
	{
		$query = "SELECT festivalcourses.group  AS `group` FROM festivalcourses WHERE festivalcourses.festival_id = $_festival_id GROUP BY festivalcourses.group ";
		$result = \dash\db::get($query, 'group');
		$result = array_filter($result);
		$result = array_unique($result);
		return $result;
	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search($_string = null, $_option = [])
	{
		if(!is_array($_option))
		{
			$_option = [];
		}

		$default_option =
		[
			'search_field' => "( festivals.title LIKE '%__string__%') ",
		];

		$_option = array_merge($default_option, $_option);
		return \dash\db\config::public_search('festivals', $_string, $_option);
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
			$query = "DELETE FROM festivals WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>