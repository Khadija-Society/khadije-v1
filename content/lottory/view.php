<?php
namespace content\lottory;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Signup karbala"));
		\dash\data::page_desc(\dash\data::site_desc());

		$winners = self::load_level(); // sample for test
		$winners = self::winners(); // master result

		\dash\data::winners(json_encode($winners , JSON_UNESCAPED_UNICODE));
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


	public static function load_level()
	{

		// md5 of level url
		$level = \dash\request::get('level');
		// 32 md5 and step level >= 32
		if(mb_strlen($level) >= 32)
		{
			$md5  = substr($level, 0, 32);
			$step = substr($level, 32);

			if(!is_numeric($step))
			{
				\dash\header::status(404, T_("Invalid step"));
				return false;
			}

			$load_level = \lib\app\lottery::load_lottery('karbala2users', $md5, $step);
			return $load_level;

		}
		else
		{
			return;
		}

	}
}
?>
