<?php
namespace lib\db;

class send
{


	/**
	 * insert new agent_sendprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('agent_send', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update agent_sendprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('agent_send', ...func_get_args());
	}


	/**
	 * get agent_sendprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('agent_send', ...func_get_args());
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
			'search_field'      =>" (agent_send.title LIKE '%__string__%' OR agent_send.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('agent_send', $_string, $_options);
	}


}
?>