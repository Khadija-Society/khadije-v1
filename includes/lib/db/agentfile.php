<?php
namespace lib\db;

class agentfile
{

	public static function remove($_id)
	{
		$query  = "DELETE FROM agent_file WHERE agent_file.id = $_id LIMIT 1 ";
		$result = \dash\db::query($query);
		return $result;
	}

	/**
	 * insert new agent_fileprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('agent_file', ...func_get_args());
		return \dash\db::insert_id();
	}


	private static $options =
	[
		'public_show_field' =>
		"
			agent_file.*,

			IFNULL(users.displayname, CONCAT(users.firstname, ' ', users.lastname)) AS `displayname`,
			users.avatar AS `avatar`,
			users.mobile AS `mobile`


		",

		'master_join' =>
		"
			LEFT JOIN users  		ON users.id      = agent_file.creator



		",
	];


	/**
	 * update agent_fileprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('agent_file', ...func_get_args());
	}


	/**
	 * get agent_fileprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get($_args)
	{
		$options = self::$options;

		$result = \dash\db\config::public_get('agent_file', $_args, $options);

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
			'search_field'      =>" (agent_file.title LIKE '%__string__%' OR agent_file.subtitle LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('agent_file', $_string, $_options);
	}


}
?>