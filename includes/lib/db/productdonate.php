<?php
namespace lib\db;

class productdonate
{

	public static function summary($_args)
	{
		$where = null;
		if($_args)
		{
			$WHERE = \dash\db\config::make_where($_args);
			$where = " WHERE ". $WHERE;
		}

		$query =
		"
			SELECT
				COUNT(DISTINCT productdonate.product_id) AS `product`,
				SUM(productdonate.count) AS `product_count`,
				SUM(productdonate.total) AS `total`
			FROM
				productdonate
			$where

		";

		$result = \dash\db::get($query, null, true);
		return $result;
	}

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
			'public_show_field' =>
			"
				productdonate.*,
				product.title,
				product.subtitle,
				product.unit,
				users.displayname,
				users.avatar,
				users.gender,
				users.mobile
			",
			"master_join" =>
			"
				LEFT JOIN users ON users.id = productdonate.user_id
				LEFT JOIN product ON product.id = productdonate.product_id
			",
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('productdonate', $_string, $_options);

		return $result;
	}


}
?>