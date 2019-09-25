<?php
namespace lib\app;

class karbalasetting
{
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