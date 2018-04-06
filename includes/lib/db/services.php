<?php
namespace lib\db;

class services
{

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('services', ...func_get_args());
		return \dash\db::insert_id();
	}

	public static function mulit_insert()
	{
		return \dash\db\config::public_multi_insert('services', ...func_get_args());
	}

	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('services', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('services', ...func_get_args());
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

					services.expert = '__string__'

				)
			",
			'public_show_field' =>
			"

				users.firstname      AS `firstname`,
				users.mobile         AS `mobile`,
				users.birthday       AS `birthday`,
				users.homeaddress    AS `address`,
				users.province       AS `province`,
				users.phone          AS `phone`,
				users.zipcode        AS `zipcode`,
				users.email          AS `email`,
				users.pasportdate    AS `pasportdate`,
				users.pasportcode    AS `pasportcode`,
				users.married        AS `married`,
				users.city           AS `city`,
				users.country        AS `country`,
				users.gender         AS `gender`,
				users.father         AS `father`,
				users.lastname       AS `lastname`,
				users.nationalcode   AS `nationalcode`,
				services.*
			",
			'master_join'       =>
			"
				INNER JOIN users ON users.id = services.user_id

			",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('services', $_string, $_options);
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
			$query = "DELETE FROM services WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>