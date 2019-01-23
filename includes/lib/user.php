<?php
namespace lib;

class user
{

	public static function user_in_all_table($_user_id)
	{

		$result                = [];
		$result['travels']     = \lib\db\travels::get_count(['user_id' => $_user_id]);
		$result['services']    = \lib\db\services::get_count(['user_id' => $_user_id]);
		$result['travelusers'] = \lib\db\travelusers::get_count(['user_id' => $_user_id]);

		return $result;
	}
}
?>
