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

}
?>