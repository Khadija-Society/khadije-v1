<?php
namespace lib\db;

class lottery_user
{

	public static function get_rand($_limit)
	{
		$query = "SELECT lottery_user.id AS `id` FROM lottery_user WHERE lottery_user.lottery_id IS NULL ORDER BY RAND() LIMIT $_limit";
		$result = \dash\db::get($query, 'id');
		return $result;
	}

	public static function update_win($_ids, $_lottery_id)
	{
		$query = "UPDATE lottery_user SET lottery_user.lottery_id = $_lottery_id WHERE lottery_user.id IN ($_ids) ";
		$result = \dash\db::query($query);
		return $result;
	}

	public static function remove_lottery_id($_lottery_id)
	{
		$query = "UPDATE lottery_user SET lottery_user.lottery_id = NULL WHERE lottery_user.lottery_id = $_lottery_id ";
		$result = \dash\db::query($query);
		return $result;
	}



	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('lottery_user', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function chart_province()
	{
		$query = "SELECT COUNT(*) AS `count`, lottery_user.province FROM lottery_user GROUP BY lottery_user.province ORDER BY COUNT(*) DESC";
		$result = \dash\db::get($query, ['province', 'count']);
		return $result;
	}

	public static function daily_chart()
	{
		$query = "SELECT COUNT(*) AS `count`, DATE(lottery_user.datecreated) AS `date` FROM lottery_user GROUP BY DATE(lottery_user.datecreated) ORDER BY DATE(lottery_user.datecreated) ASC";
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
		return \dash\db\config::public_update('lottery_user', ...func_get_args());
	}

	public static function count_signup($_lottery_id)
	{
		$query = "SELECT COUNT(*) AS `count` FROM lottery_user WHERE lottery_user.lottery_id = $_lottery_id";
		$result = \dash\db::get($query, 'count', true);
		return intval($result);
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('lottery_user', ...func_get_args());
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
			$query = "SELECT * FROM lottery_user WHERE $where ORDER BY lottery_user.sort ASC, lottery_user.id ASC $limit";
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
				lottery_user.nationalcode = '__string__' OR
				lottery_user.phone = '__string__' OR
				lottery_user.firstname LIKE '__string__%' OR
				lottery_user.lastname LIKE '__string__%' OR
				lottery_user.displayname = '__string__%'
			)
		";

		$mobile = \dash\utility\filter::mobile($_string);
		if($mobile || is_numeric($_string))
		{
			$search_field =
			"
				(
					lottery_user.mobile = '$mobile' OR
					lottery_user.nationalcode = '__string__' OR
					lottery_user.phone = '__string__'
				)
			";
		}
		else
		{
			$search_field =
			"
				(
					lottery_user.firstname LIKE '__string__%' OR
					lottery_user.lastname LIKE '__string__%' OR
					lottery_user.displayname = '__string__%'
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

		$result = \dash\db\config::public_search('lottery_user', $_string, $_option);
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
			$query = "DELETE FROM lottery_user WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>