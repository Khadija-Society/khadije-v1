<?php
namespace lib\app;

class karbalasetting
{

	public static function stat()
	{

		$signup   = 0;
		$awaiting = 0;
		$gone     = 0;

		// gone group trip
		$gone_group_trip = \lib\db\karbalasetting::gone_group_trip();
		if(is_numeric($gone_group_trip))
		{
			$gone += intval($gone_group_trip);
		}

		// samte khoda qore keshi
		// 12 province in every province 40 person
		$gone += (12 * 40);
		// koye mohebbat qore keshi
		$gone += 0;
		// static number from khalili
		$gone += 0;


		$signup_group_trip = \lib\db\karbalasetting::signup_group_trip();
		if(is_numeric($signup_group_trip))
		{
			$signup += intval($signup_group_trip);
		}

		$count_signup_samtekhoda = \lib\db\karbalasetting::count_signup_samtekhoda();
		if(is_numeric($count_signup_samtekhoda))
		{
			$signup += intval($count_signup_samtekhoda);
		}

		$count_signup_koyemohebbat = \lib\db\karbalasetting::count_signup_koyemohebbat();
		if(is_numeric($count_signup_koyemohebbat))
		{
			$signup += intval($count_signup_koyemohebbat);
		}

		$result =
		[
			'gone'     => $gone,
			'signup'   => $signup,
			'awaiting' => $signup - $gone,
		];
		// j($result);
		return $result;
	}


	private static function addr()
	{
		return __DIR__.'/karbalasetting.me.json';
	}

	public static function set($_args)
	{
		\dash\app::variable($_args);
		$setting =
		[
			'samtekhoda'   => \dash\app::request('samtekhoda') ? true : false,
			'koyemohebbat' => \dash\app::request('koyemohebbat') ? true : false,
			'arbaeen'      => \dash\app::request('arbaeen') ? true : false,
		];

		$setting = json_encode($setting, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		\dash\notif::ok(T_("Status changed"));
		\dash\file::write(self::addr(), $setting);
		return true;
	}

	public static function get()
	{
		$get = \dash\file::read(self::addr());
		if(is_string($get))
		{
			$get = json_decode($get, true);
		}

		$setting =
		[
			'samtekhoda'   => (isset($get['samtekhoda']) && $get['samtekhoda']) ? true : false,
			'koyemohebbat' => (isset($get['koyemohebbat']) && $get['koyemohebbat']) ? true : false,
			'arbaeen'      => (isset($get['arbaeen']) && $get['arbaeen']) ? true : false,
		];

		return $setting;
	}


	public static function check($_key)
	{
		$get = self::get();
		if(isset($get[$_key]) && $get[$_key])
		{
			return true;
		}
		return false;
	}
}
?>