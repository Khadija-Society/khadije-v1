<?php
namespace lib\db;

class assessmentitem
{

	public static function check_place_status($_ids)
	{
		$query  = "SELECT agent_assessmentitem.* FROM agent_assessmentitem WHERE agent_assessmentitem.id IN ($_ids) AND agent_assessmentitem.status = 'enable' ";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new agent_assessmentitemprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('agent_assessmentitem', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update agent_assessmentitemprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('agent_assessmentitem', ...func_get_args());
	}


	/**
	 * get agent_assessmentitemprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('agent_assessmentitem', ...func_get_args());
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
			'search_field'      =>" (agent_assessmentitem.title LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('agent_assessmentitem', $_string, $_options);
	}


}
?>