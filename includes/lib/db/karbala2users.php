<?php
namespace lib\db;

class karbala2users
{

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('karbala2users', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function chart_province()
	{
		$query = "SELECT COUNT(*) AS `count`, karbala2users.province FROM karbala2users GROUP BY karbala2users.province ORDER BY COUNT(*) DESC";
		$result = \dash\db::get($query, ['province', 'count']);
		return $result;
	}

	public static function daily_chart()
	{
		$query = "SELECT COUNT(*) AS `count`, DATE(karbala2users.datecreated) AS `date` FROM karbala2users GROUP BY DATE(karbala2users.datecreated) ORDER BY DATE(karbala2users.datecreated) ASC";
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
		return \dash\db\config::public_update('karbala2users', ...func_get_args());
	}

	public static function get_last_id()
	{
		$query = "SELECT karbala2users.id AS `id` FROM karbala2users ORDER BY karbala2users.id DESC LIMIT 1";
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
		$result = \dash\db\config::public_get('karbala2users', ...func_get_args());
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
			$query = "SELECT * FROM karbala2users WHERE $where ORDER BY karbala2users.sort ASC, karbala2users.id ASC $limit";
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
				karbala2users.nationalcode = '__string__' OR
				karbala2users.phone = '__string__' OR
				karbala2users.firstname LIKE '__string__%' OR
				karbala2users.lastname LIKE '__string__%' OR
				karbala2users.displayname = '__string__%'
			)
		";

		$mobile = \dash\utility\filter::mobile($_string);
		if($mobile || is_numeric($_string))
		{
			$search_field =
			"
				(
					karbala2users.mobile = '$mobile' OR
					karbala2users.nationalcode = '__string__' OR
					karbala2users.phone = '__string__'
				)
			";
		}
		else
		{
			$search_field =
			"
				(
					karbala2users.firstname LIKE '__string__%' OR
					karbala2users.lastname LIKE '__string__%' OR
					karbala2users.displayname = '__string__%'
				)
			";
		}

		$default_option =
		[
			'search_field' => $search_field,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		$result = \dash\db\config::public_search('karbala2users', $_string, $_option);
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
			$query = "DELETE FROM karbala2users WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>