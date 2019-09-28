<?php
namespace lib\db;

class place
{

	public static function check_place_status($_ids)
	{
		$query  = "SELECT place.* FROM place WHERE place.id IN ($_ids) AND place.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new placeprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('place', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update placeprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('place', ...func_get_args());
	}


	/**
	 * get placeprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('place', ...func_get_args());
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
			'search_field'      =>" (place.title LIKE '%__string__%' OR place.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('place', $_string, $_options);
	}


}
?>