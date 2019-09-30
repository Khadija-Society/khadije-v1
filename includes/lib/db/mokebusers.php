<?php
namespace lib\db;

class mokebusers
{
	public static function get_by_position($_position)
	{
		$now = date("Y-m-d H:i:s");
		$query =
		"
			SELECT
				*
			FROM mokebusers
			WHERE
				mokebusers.position = '$_position' AND
				mokebusers.forceexit IS NULL AND
				mokebusers.expire > '$now'
			ORDER BY mokebusers.id DESC
			LIMIT 1
		";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function get_ids()
	{
		$query =
		"
			SELECT
				mokebusers.id AS `id`
			FROM mokebusers
		";
		$result = \dash\db::get($query, 'id');
		return $result;
	}

	public static function all_user()
	{
		$query =
		"
			SELECT
				mokebusers.id,
				mokebusers.firstname,
				mokebusers.lastname,
				mokebusers.nationalcode,
				mokebusers.mobile,
				mokebusers.gender,
				mokebusers.married,
				mokebusers.place_id,
				mokebusers.position,
				mokebusers.expire,
				mokebusers.datecreated,
				mokebusers.displayname,
				mokebusers.birthday,
				mokebusers.father,
				mokebusers.city,
				mokebusers.province,
				mokebusers.country
			FROM mokebusers
		";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function all_place()
	{
		$query =
		"
			SELECT
				*
			FROM place
		";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function all_full($_place_id, $_date)
	{
		$query =
		"
			SELECT
				mokebusers.position
			FROM
				mokebusers
			WHERE
				mokebusers.place_id = $_place_id AND
				mokebusers.expire > '$_date'
		";
		$result = \dash\db::get($query, 'position');
		return $result;
	}


	public static function all_full_place($_place_ids)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				mokebusers.place_id
			FROM
				mokebusers
			WHERE
				mokebusers.place_id IN ($_place_ids)
			GROUP BY mokebusers.place_id
		";
		$result = \dash\db::get($query, ['place_id', 'count']);
		return $result;
	}

	public static function all_full_place_date($_place_ids, $_date)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`,
				mokebusers.place_id
			FROM
				mokebusers
			WHERE
				date(mokebusers.datecreated) = date('$_date') AND
				mokebusers.place_id IN ($_place_ids)
			GROUP BY mokebusers.place_id
		";
		$result = \dash\db::get($query, ['place_id', 'count']);
		return $result;
	}




	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('mokebusers', ...func_get_args());
		return \dash\db::insert_id();
	}

	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('mokebusers', ...func_get_args());
	}


	public static function chart_province()
	{
		$query = "SELECT COUNT(*) AS `count`, mokebusers.province FROM mokebusers GROUP BY mokebusers.province ORDER BY COUNT(*) DESC";
		$result = \dash\db::get($query, ['province', 'count']);
		return $result;
	}

	public static function daily_chart()
	{
		$query = "SELECT COUNT(*) AS `count`, DATE(mokebusers.datecreated) AS `date` FROM mokebusers GROUP BY DATE(mokebusers.datecreated) ORDER BY DATE(mokebusers.datecreated) ASC";
		$result = \dash\db::get($query);
		return $result;
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('mokebusers', ...func_get_args());
	}

	public static function get_last_id()
	{
		$query = "SELECT mokebusers.id AS `id` FROM mokebusers ORDER BY mokebusers.id DESC LIMIT 1";
		$result = \dash\db::get($query, 'id', true);
		return intval($result);
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('mokebusers', ...func_get_args());
		return $result;
	}


	public static function get_sort($_where)
	{
		$limit = null;
		$only_one_value = false;
		if(isset($_where['limit']))
		{
			if($_where['limit'] === 1)
			{
				$only_one_value = true;
			}

			$limit = " LIMIT $_where[limit] ";
		}

		unset($_where['limit']);

		$where = \dash\db\config::make_where($_where);
		if($where)
		{
			$query = "SELECT * FROM mokebusers WHERE $where ORDER BY mokebusers.sort ASC, mokebusers.id ASC $limit";
			$result = \dash\db::get($query, null, $only_one_value);
			return $result;
		}
		return false;

	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search($_string = null, $_option = [])
	{
		$search_field =
		"
			(
				mokebusers.nationalcode = '__string__' OR
				mokebusers.phone = '__string__' OR
				mokebusers.firstname LIKE '__string__%' OR
				mokebusers.lastname LIKE '__string__%' OR
				mokebusers.displayname = '__string__%'
			)
		";

		$mobile = \dash\utility\filter::mobile($_string);
		if($mobile || is_numeric($_string))
		{
			$search_field =
			"
				(
					mokebusers.mobile = '$mobile' OR
					mokebusers.nationalcode = '__string__' OR
					mokebusers.phone = '__string__'
				)
			";
		}
		else
		{
			$search_field =
			"
				(
					mokebusers.firstname LIKE '__string__%' OR
					mokebusers.lastname LIKE '__string__%' OR
					mokebusers.displayname = '__string__%'
				)
			";
		}

		$default_option =
		[
			'search_field' => $search_field,
			'public_show_field' => "mokebusers.*, place.title AS `place_title`",
			'master_join' => "LEFT JOIN place ON place.id = mokebusers.place_id"
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$result = \dash\db\config::public_search('mokebusers', $_string, $_option);
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
			$query = "DELETE FROM mokebusers WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>