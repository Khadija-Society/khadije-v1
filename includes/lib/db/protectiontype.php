<?php
namespace lib\db;

class protectiontype
{

	public static function get_all()
	{
		$query  = "SELECT protection_type.* FROM protection_type WHERE protection_type.status != 'deleted'";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function get_occasion_type($_occasion_id)
	{
		$query  = "SELECT protection_type.title, protection_type.id FROM protection_type INNER JOIN protection_occasion_type ON protection_occasion_type.type_id = protection_type.id WHERE protection_type.status != 'deleted' AND protection_occasion_type.protection_occasion_id = $_occasion_id ";
		$result = \dash\db::get($query);
		return $result;
	}

	public static function remove_all($_occasion_id)
	{
		$query  = "DELETE FROM protection_occasion_type WHERE protection_occasion_type.protection_occasion_id = $_occasion_id ";
		$result = \dash\db::query($query);
		return $result;
	}


	public static function change($_type_ids, $_occasion_id)
	{

		$multi_insert = [];
		foreach ($_type_ids as $key => $value)
		{
			$multi_insert[] =
			[
				'protection_occasion_id' => $_occasion_id,
				'type_id'                => $value,
				'datecreated'            => date("Y-m-d H:i:s"),
			];
		}


		$result = \dash\db\config::public_multi_insert('protection_occasion_type', $multi_insert);
		return $result;

	}



	/**
	 * insert new protection_typeprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('protection_type', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function insert_detail()
	{
		\dash\db\config::public_insert('protection_type', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update protection_typeprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('protection_type', ...func_get_args());
	}


	/**
	 * get protection_typeprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('protection_type', ...func_get_args());
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
			'search_field'      =>" (protection_type.title LIKE '%__string__%' OR users.mobile LIKE '%__string__%' OR protection_type.type LIKE '%__string__%') ",
			'public_show_field' => " protection_type.*, users.mobile ",
			'master_join' => "LEFT JOIN users ON users.id = protection_type.user_id"
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('protection_type', $_string, $_options);
		return $result;
	}


}
?>