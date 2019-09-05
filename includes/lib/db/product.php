<?php
namespace lib\db;

class product
{

	public static function check_product_status($_ids)
	{
		$query  = "SELECT product.* FROM product WHERE product.id IN ($_ids) AND product.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('product', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('product', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('product', ...func_get_args());
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
			'search_field'      =>" (product.title LIKE '%__string__%' OR product.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('product', $_string, $_options);
	}


}
?>