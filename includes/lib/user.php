<?php
namespace lib;

class user
{

	public static function user_in_all_table($_user_id)
	{

		$result                = [];

		$result['travels']     =
		[
			'count'  => \lib\db\travels::get_count(['user_id' => $_user_id]),
			'link'   => \dash\url::kingdom(). '/cms/trip?user_id=',
			'encode' => false,
		];

		$result['services']    =
		[
			'count'  => \lib\db\services::get_count(['user_id' => $_user_id]),
			'link'   => \dash\url::kingdom(). '/cms/service?user_id=',
			'encode' => false,
		];

		$result['travelusers'] =
		[
			'count'  => \lib\db\travelusers::get_count(['user_id' => $_user_id]),
			'link'   => null,
			'encode' => false,
		];




		return $result;
	}
}
?>
