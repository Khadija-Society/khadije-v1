<?php
namespace lib\db;

class nationalcodes
{

	public static function add($_nationalcode)
	{
		if($_nationalcode)
		{
			$query = "INSERT IGNORE INTO nationalcodes SET nationalcodes.nationalcode = '$_nationalcode' ";
			\lib\db::query($query);
		}
	}

	/**
	 * insert new productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\lib\db\config::public_insert('nationalcodes', ...func_get_args());
		return \lib\db::insert_id();
	}


	/**
	 * update productprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \lib\db\config::public_update('nationalcodes', ...func_get_args());
	}


	/**
	 * get productprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \lib\db\config::public_get('nationalcodes', ...func_get_args());
		return $result;
	}


	/**
	 * Searches for the first match.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function search()
	{
		return \lib\db\config::public_search('nationalcodes', ...func_get_args());
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
			$query = "DELETE FROM nationalcodes WHERE $where";
			return \lib\db::query($query);
		}
		return false;
	}
}
?>