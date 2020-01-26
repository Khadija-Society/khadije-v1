<?php
namespace lib\db;


class find
{

	public static function karevani($_user_id)
	{
		$query = "SELECT travels.* FROM travelusers INNER JOIN travels ON travels.id = travelusers.travel_id WHERE travelusers.user_id = $_user_id";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function karevani_admin($_user_id)
	{
		$query = "SELECT * FROM travels WHERE travels.user_id = $_user_id";
		$result = \dash\db::get($query);
		return $result;

	}




	public static function nationalcode($_nationalcode)
	{
		$query = "SELECT * FROM nationalcodes WHERE nationalcodes.nationalcode = $_nationalcode LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function mokeb_nationalcode($_nationalcode)
	{
		$query = "SELECT * FROM mokebusers WHERE mokebusers.nationalcode = $_nationalcode";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function mokeb_mobile($_mobile)
	{
		$query = "SELECT * FROM mokebusers WHERE mokebusers.mobile = $_mobile";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function koyemohabbat_nationalcode($_nationalcode)
	{
		$query = "SELECT * FROM karbala2users WHERE karbala2users.nationalcode = $_nationalcode LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function koyemohabbat_mobile($_mobile)
	{
		$query = "SELECT * FROM karbala2users WHERE karbala2users.mobile = $_mobile LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function samtekhoda_nationalcode($_nationalcode)
	{
		$query = "SELECT * FROM karbalausers WHERE karbalausers.nationalcode = $_nationalcode LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function samtekhoda_mobile($_mobile)
	{
		$query = "SELECT * FROM karbalausers WHERE karbalausers.mobile = $_mobile LIMIT 1";
		$result = \dash\db::get($query, null, true);
		return $result;
	}



	public static function agent($_user_id)
	{
		$query =
		"
			SELECT * FROM agent_send
			WHERE
			(
				agent_send.clergy_id      = $_user_id OR
				agent_send.admin_id       = $_user_id OR
				agent_send.adminoffice_id = $_user_id OR
				agent_send.missionary_id  = $_user_id OR
				agent_send.servant_id     = $_user_id OR
				agent_send.servant2_id    = $_user_id OR
				agent_send.khadem2_id     = $_user_id OR
				agent_send.khadem_id      = $_user_id OR
				agent_send.nazer_id       = $_user_id OR
				agent_send.rabet_id       = $_user_id OR
				agent_send.maddah_id      = $_user_id
			)
		";
		$result = \dash\db::get($query);
		return $result;
	}

}
?>