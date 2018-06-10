<?php
namespace lib\db;

class salavats
{
	public static function befrest()
	{
		$insert = [];
		if(\dash\user::id())
		{
			$insert['user_id'] = \dash\user::id();
		}
		else
		{
			$insert['user_id'] = null;
		}

		return self::insert($insert);
	}


	public static function shomar()
	{
		$query = "SELECT COUNT(*) AS `count` FROM salavats ";
		$count = \dash\db::get($query, 'count', true);
		return intval($count);
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('salavats', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('salavats', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('salavats', ...func_get_args());
		return $result;
	}

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
					users.mobile LIKE '%__string__%' OR
					users.nationalcode LIKE '%__string__%'

				)
			",
			'public_show_field' =>
			"
				users.*, (SELECT COUNT(*) FROM salavats WHERE salavats.user_id = users.id) AS `salavat_shomar`
			",
			'(SELECT COUNT(*) FROM salavats WHERE salavats.user_id = users.id)' => [" >= ", "1"],
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('users', $_string, $_options);
	}


}
?>