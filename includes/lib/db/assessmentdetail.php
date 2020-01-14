<?php
namespace lib\db;

class assessmentdetail
{

	public static function check_place_status($_ids)
	{
		$query  = "SELECT agent_assessmentdetail.* FROM agent_assessmentdetail WHERE agent_assessmentdetail.id IN ($_ids) AND agent_assessmentdetail.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new agent_assessmentdetailprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('agent_assessmentdetail', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update agent_assessmentdetailprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('agent_assessmentdetail', ...func_get_args());
	}


	/**
	 * get agent_assessmentdetailprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('agent_assessmentdetail', ...func_get_args());
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
			'search_field'      =>" (agent_assessmentdetail.title LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('agent_assessmentdetail', $_string, $_options);
	}


}
?>