<?php
namespace content_mokeb\home;


class view
{
	public static function config()
	{
		\dash\data::page_title("سامانه مدیریت اقامت کوتاه مدت در موکب");

		$args =
		[
			'pagenation' => false,
			'status' => 'enable',

		];
		$list = \lib\app\place::list(null, $args);
		$list = \lib\app\mokebuser::place_dashboard($list);
		\dash\data::mokebList($list);
	}
}
?>
