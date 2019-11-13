<?php
namespace content\lottory;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		$winers = self::winers();
		\dash\data::winers($winers);
	}



	private static function winers()
	{
		$winers = [];
		$winers[] =
		[
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winers[] =
		[
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winers[] =
		[
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winers[] =
		[
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];

		$winers[] =
		[
			'id'     => 4440032109,
			'name'   => 'رضا محیطی',
			'mobile' => '989109610612',
		];
		return $winers;
	}
}
?>
