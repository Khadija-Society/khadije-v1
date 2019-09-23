<?php
namespace lib\db;

class karbalaarbaeenusers
{

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('karbalaarbaeenusers', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function chart_province()
	{
		$query = "SELECT COUNT(*) AS `count`, karbalaarbaeenusers.province FROM karbalaarbaeenusers GROUP BY karbalaarbaeenusers.province ORDER BY COUNT(*) DESC";
		$result = \dash\db::get($query, ['province', 'count']);
		return $result;
	}

	public static function daily_chart()
	{
		$query = "SELECT COUNT(*) AS `count`, DATE(karbalaarbaeenusers.datecreated) AS `date` FROM karbalaarbaeenusers GROUP BY DATE(karbalaarbaeenusers.datecreated) ORDER BY DATE(karbalaarbaeenusers.datecreated) ASC";
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
		return \dash\db\config::public_update('karbalaarbaeenusers', ...func_get_args());
	}

	public static function get_last_id()
	{
		$query = "SELECT karbalaarbaeenusers.id AS `id` FROM karbalaarbaeenusers ORDER BY karbalaarbaeenusers.id DESC LIMIT 1";
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
		$result = \dash\db\config::public_get('karbalaarbaeenusers', ...func_get_args());
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
			$query = "SELECT * FROM karbalaarbaeenusers WHERE $where ORDER BY karbalaarbaeenusers.sort ASC, karbalaarbaeenusers.id ASC $limit";
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
				karbalaarbaeenusers.nationalcode = '__string__' OR
				karbalaarbaeenusers.phone = '__string__' OR
				karbalaarbaeenusers.firstname LIKE '__string__%' OR
				karbalaarbaeenusers.lastname LIKE '__string__%' OR
				karbalaarbaeenusers.displayname = '__string__%'
			)
		";

		$mobile = \dash\utility\filter::mobile($_string);
		if($mobile || is_numeric($_string))
		{
			$search_field =
			"
				(
					karbalaarbaeenusers.mobile = '$mobile' OR
					karbalaarbaeenusers.nationalcode = '__string__' OR
					karbalaarbaeenusers.phone = '__string__'
				)
			";
		}
		else
		{
			$search_field =
			"
				(
					karbalaarbaeenusers.firstname LIKE '__string__%' OR
					karbalaarbaeenusers.lastname LIKE '__string__%' OR
					karbalaarbaeenusers.displayname = '__string__%'
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

		$result = \dash\db\config::public_search('karbalaarbaeenusers', $_string, $_option);
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
			$query = "DELETE FROM karbalaarbaeenusers WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>