<?php
namespace lib\db;

class syslottery
{

	public static function check_place_status($_ids)
	{
		$query  = "SELECT lottery_list.* FROM lottery_list WHERE lottery_list.id IN ($_ids) AND lottery_list.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new lottery_listprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('lottery_list', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update lottery_listprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('lottery_list', ...func_get_args());
	}


	/**
	 * get lottery_listprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('lottery_list', ...func_get_args());
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
			'search_field'      =>" (lottery_list.title LIKE '%__string__%' OR lottery_list.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('lottery_list', $_string, $_options);
	}


}
?>