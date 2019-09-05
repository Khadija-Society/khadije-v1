<?php
namespace lib\db;

class productdonate
{



	/**
	 * insert new productdonateprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('productdonate', ...func_get_args());
		return \dash\db::insert_id();
	}

	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('productdonate', ...func_get_args());
	}


	/**
	 * update productdonateprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('productdonate', ...func_get_args());
	}


	/**
	 * get productdonateprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('productdonate', ...func_get_args());
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
			'search_field'      =>" (productdonate.title LIKE '%__string__%' OR productdonate.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('productdonate', $_string, $_options);
	}


}
?>