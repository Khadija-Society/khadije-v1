<?php
namespace lib\db;

class travels
{

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\lib\db\config::public_insert('travels', ...func_get_args());
		return \lib\db::insert_id();
	}

	public static function mulit_insert()
	{
		return \lib\db\config::public_multi_insert('travels', ...func_get_args());
	}

	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('travels', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \lib\db\config::public_get('travels', ...func_get_args());
		return $result;
	}


/**
	 * Searches for the first match.
	 *
	 * @param      <type>  $_string   The string
	 * @param      array   $_options  The options
	 */
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
					users.nationalcode LIKE '%__string__%' OR
					travels.id = '__string__' OR
					travels.place = '__string__'

				)
			",
			'public_show_field' =>
			"
				nationalcodes.qom    AS `qom`,
				nationalcodes.mashhad AS `mashhad`,
				nationalcodes.karbala AS `karbala`,
				users.firstname      AS `firstname`,
				users.mobile         AS `mobile`,
				users.birthday       AS `birthday`,
				users.province       AS `province`,
				users.married        AS `married`,
				users.city           AS `city`,
				users.country        AS `country`,
				users.gender         AS `gender`,
				users.father         AS `father`,
				users.lastname       AS `lastname`,
				users.nationalcode   AS `nationalcode`,
				 travels.*
			",
			'master_join'       =>
			"
				INNER JOIN users ON users.id = travels.user_id
				LEFT JOIN nationalcodes ON nationalcodes.nationalcode = users.nationalcode
			",
		];

		$_options = array_merge($default_option, $_options);
		return \lib\db\config::public_search('travels', $_string, $_options);
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
		$where = \lib\db\config::make_where($_where);
		if($where)
		{
			$query = "DELETE FROM travels WHERE $where";
			return \lib\db::query($query);
		}
		return false;
	}
}
?>