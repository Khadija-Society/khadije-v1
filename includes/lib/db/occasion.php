<?php
namespace lib\db;

class occasion
{

	public static function check_place_status($_ids)
	{
		$query  = "SELECT protection_occasion.* FROM protection_occasion WHERE protection_occasion.id IN ($_ids) AND protection_occasion.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new protection_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_occasion', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_occasionprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_occasion', ...func_get_args());
	}


	/**
	 * get protection_occasionprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_occasion', ...func_get_args());
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
			'search_field'      =>" (protection_occasion.title LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('protection_occasion', $_string, $_options);
	}


}
?>