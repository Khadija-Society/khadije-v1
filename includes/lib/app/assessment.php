<?php
namespace lib\app;

/**
 * Class for place.
 */
class assessment
{

	public static function get_item_by_send($_id, $_job, $_job_2)
	{
		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			\dash\notif::error(T_("Send id not set"));
			return false;
		}

		$send_detail = \lib\db\send::get(['agent_send.id' => $id, 'limit' => 1]);

		if(!$send_detail)
		{
			\dash\notif::error(T_("Invalid send id"));
			return false;
		}

		$job = $_job;
		$city = $send_detail['city'];

		$item_list = \lib\db\assessment::get_list($job, $city, $_job_2);


		return $item_list;
	}
}
?>