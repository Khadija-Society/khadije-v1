<?php
namespace content\lottory;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		\dash\data::winners(json_encode(self::winners() , JSON_UNESCAPED_UNICODE));
	}



	private static function winners()
	{
		$winners = [];
		$winners[] =
		[
			'index'  => 1,
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
			'skip'   => true,
		];

		$winners[] =
		[
			'index'  => 2,
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
			'skip'   => true,
		];

		$winners[] =
		[
			'index'  => 3,
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winners[] =
		[
			'index'  => 4,
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winners[] =
		[
			'index'  => 5,
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];
		return $winners;
	}
}
?>
