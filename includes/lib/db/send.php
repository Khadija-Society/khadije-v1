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
			clergy.nationalcode AS `clergy_nationalcode`,
			clergy.gender AS `clergy_gender`,

			IFNULL(admin.displayname, CONCAT(admin.firstname, ' ', admin.lastname)) AS `admin_displayname`,
			admin.avatar AS `admin_avatar`,
			admin.mobile AS `admin_mobile`,
			admin.nationalcode AS `admin_nationalcode`,
			admin.gender AS `admin_gender`,

			IFNULL(adminoffice.displayname, CONCAT(adminoffice.firstname, ' ', adminoffice.lastname)) AS `adminoffice_displayname`,
			adminoffice.avatar AS `adminoffice_avatar`,
			adminoffice.mobile AS `adminoffice_mobile`,
			adminoffice.nationalcode AS `adminoffice_nationalcode`,
			adminoffice.gender AS `adminoffice_gender`,

			IFNULL(missionary.displayname, CONCAT(missionary.firstname, ' ', missionary.lastname)) AS `missionary_displayname`,
			missionary.avatar AS `missionary_avatar`,
			missionary.mobile AS `missionary_mobile`,
			missionary.nationalcode AS `missionary_nationalcode`,
			missionary.gender AS `missionary_gender`,

			IFNULL(servant.displayname, CONCAT(servant.firstname, ' ', servant.lastname)) AS `servant_displayname`,
			servant.avatar AS `servant_avatar`,
			servant.mobile AS `servant_mobile`,
			servant.nationalcode AS `servant_nationalcode`,
			servant.gender AS `servant_gender`,

			IFNULL(servant2.displayname, CONCAT(servant2.firstname, ' ', servant2.lastname)) AS `servant2_displayname`,
			servant2.avatar AS `servant2_avatar`,
			servant2.mobile AS `servant2_mobile`,
			servant2.nationalcode AS `servant2_nationalcode`,
			servant2.gender AS `servant2_gender`,

			IFNULL(maddah.displayname, CONCAT(maddah.firstname, ' ', maddah.lastname)) AS `maddah_displayname`,
			maddah.avatar AS `maddah_avatar`,
			maddah.mobile AS `maddah_mobile`,
			maddah.nationalcode AS `maddah_nationalcode`,
			maddah.gender AS `maddah_gender`,

			IFNULL(nazer.displayname, CONCAT(nazer.firstname, ' ', nazer.lastname)) AS `nazer_displayname`,
			nazer.avatar AS `nazer_avatar`,
			nazer.mobile AS `nazer_mobile`,
			nazer.nationalcode AS `nazer_nationalcode`,
			nazer.gender AS `nazer_gender`,

			IFNULL(khadem.displayname, CONCAT(khadem.firstname, ' ', khadem.lastname)) AS `khadem_displayname`,
			khadem.avatar AS `khadem_avatar`,
			khadem.mobile AS `khadem_mobile`,
			khadem.nationalcode AS `khadem_nationalcode`,
			khadem.gender AS `khadem_gender`,

			IFNULL(khadem2.displayname, CONCAT(khadem2.firstname, ' ', khadem2.lastname)) AS `khadem2_displayname`,
			khadem2.avatar AS `khadem2_avatar`,
			khadem2.mobile AS `khadem2_mobile`,
			khadem2.nationalcode AS `khadem2_nationalcode`,
			khadem2.gender AS `khadem2_gender`,

			agent_place.title As `place_title`
		",

		'master_join' =>
		"
			LEFT JOIN users AS `clergy` 		ON clergy.id      = agent_send.clergy_id
			LEFT JOIN users AS `admin` 			ON admin.id       = agent_send.admin_id
			LEFT JOIN users AS `adminoffice` 	ON adminoffice.id = agent_send.adminoffice_id
			LEFT JOIN users AS `missionary` 	ON missionary.id  = agent_send.missionary_id
			LEFT JOIN users AS `servant` 		ON servant.id     = agent_send.servant_id
			LEFT JOIN users AS `servant2` 		ON servant2.id     = agent_send.servant2_id

			LEFT JOIN users AS `maddah` 		ON maddah.id      = agent_send.maddah_id
			LEFT JOIN users AS `nazer` 			ON nazer.id       = agent_send.nazer_id
			LEFT JOIN users AS `khadem` 		ON khadem.id      = agent_send.khadem_id
			LEFT JOIN users AS `khadem2` 		ON khadem2.id     = agent_send.khadem2_id

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
		$default['search_field'] = " ( agent_send.title LIKE '%__string__%' ) ";


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