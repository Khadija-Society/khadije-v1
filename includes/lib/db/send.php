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
	public static function get($_args)
	{
		$options =
		[
			'public_show_field' => "agent_send.*, agent_send.id as `xid`, users.displayname, users.avatar, users.mobile",
			'master_join' => "INNER JOIN users ON users.id = agent_send.user_id",
		];
		$result = \dash\db\config::public_get('agent_send', $_args, $options);

		return $result;
	}


	public static function search($_string = null, $_args = [])
	{

		$default =
		[
			'public_show_field' => "agent_send.*, agent_send.id as `xid`, users.displayname, users.avatar, users.mobile",
			'master_join' => "INNER JOIN users ON users.id = agent_send.user_id",
			'search_field' => " ( users.mobile LIKE '%__string__%' or users.displayname LIKE '%__string__%' ) ",
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default, $_args);

		$result = \dash\db\config::public_search('agent_send', $_string, $_args);
		return $result;
	}

}
?>