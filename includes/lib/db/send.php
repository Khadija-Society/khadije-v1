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


	private static $options =
	[
		'public_show_field' =>
		"
			agent_send.*,

			IFNULL(clergy.displayname, CONCAT(clergy.firstname, ' ', clergy.lastname)) AS `clergy_displayname`,
			clergy.avatar AS `clergy_avatar`,
			clergy.mobile AS `clergy_mobile`,

			IFNULL(admin.displayname, CONCAT(admin.firstname, ' ', admin.lastname)) AS `admin_displayname`,
			admin.avatar AS `admin_avatar`,
			admin.mobile AS `admin_mobile`,

			IFNULL(adminoffice.displayname, CONCAT(adminoffice.firstname, ' ', adminoffice.lastname)) AS `adminoffice_displayname`,
			adminoffice.avatar AS `adminoffice_avatar`,
			adminoffice.mobile AS `adminoffice_mobile`,

			IFNULL(missionary.displayname, CONCAT(missionary.firstname, ' ', missionary.lastname)) AS `missionary_displayname`,
			missionary.avatar AS `missionary_avatar`,
			missionary.mobile AS `missionary_mobile`,

			IFNULL(servant.displayname, CONCAT(servant.firstname, ' ', servant.lastname)) AS `servant_displayname`,
			servant.avatar AS `servant_avatar`,
			servant.mobile AS `servant_mobile`,

			agent_place.title As `place_title`
		",

		'master_join' =>
		"
			LEFT JOIN users AS `clergy` 		ON clergy.id      = agent_send.clergy_id
			LEFT JOIN users AS `admin` 			ON admin.id       = agent_send.admin_id
			LEFT JOIN users AS `adminoffice` 	ON adminoffice.id = agent_send.adminoffice_id
			LEFT JOIN users AS `missionary` 	ON missionary.id  = agent_send.missionary_id
			LEFT JOIN users AS `servant` 		ON servant.id     = agent_send.servant_id
			LEFT JOIN agent_place ON agent_place.id     = agent_send.place_id

		",
	];


	/**
	 * get agent_sendprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get($_args)
	{
		$options = self::$options;

		$result = \dash\db\config::public_get('agent_send', $_args, $options);

		return $result;
	}


	public static function search($_string = null, $_args = [])
	{

		$default = self::$options;
		$default['search_field'] = " ( users.mobile LIKE '%__string__%' or users.displayname LIKE '%__string__%' ) ";


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