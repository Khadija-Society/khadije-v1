<?php
namespace lib\db;

class nationalcodes
{
	public static function set_travel($_all_national_code, $_field)
	{
			if(!is_array($_all_national_code) || empty($_all_national_code))
		{
			return false;
		}

		$_all_national_code = implode(',', $_all_national_code);

		$query =
		"
			UPDATE
				nationalcodes
			SET
				nationalcodes.$_field = IF(nationalcodes.$_field IS NULL OR nationalcodes.$_field = '', 1, nationalcodes.$_field + 1)
			WHERE
				nationalcodes.nationalcode IN ($_all_national_code)
		";
		return \dash\db::query($query);

	}

	public static function nationalcode_travel($_all_national_code)
	{
		if(!is_array($_all_national_code) || empty($_all_national_code))
		{
			return false;
		}

		$_all_national_code = implode(',', $_all_national_code);

		$query = "SELECT * FROM nationalcodes WHERE nationalcodes.nationalcode IN ($_all_national_code)";
		return \dash\db::get($query);
	}

	public static function add($_nationalcode)
	{
		if($_nationalcode)
		{
			$query = "INSERT IGNORE INTO nationalcodes SET nationalcodes.nationalcode = '$_nationalcode' ";
			\dash\db::query($query);
		}
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('nationalcodes', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('nationalcodes', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('nationalcodes', ...func_get_args());
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
					nationalcodes.nationalcode LIKE '%__string__%'
				)
			",

		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('nationalcodes', $_string, $_options);
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
			$query = "DELETE FROM nationalcodes WHERE $where";
			return \dash\db::query($query);
		}
		return false;
	}
}
?>