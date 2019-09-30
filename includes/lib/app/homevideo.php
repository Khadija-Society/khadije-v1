<?php
namespace lib\app;

class homevideo
{
	private static function addr()
	{
		return __DIR__.'/homevideo.me.json';
	}

	public static function set($_args)
	{
		\dash\app::variable($_args);
		$setting =
		[
			'status' => \dash\app::request('status') ? true : false,
			'code'   => \dash\app::request('code'),
		];

		$setting = json_encode($setting, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		\dash\notif::ok(T_("Data changed"));
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
			'status' => (isset($get['status']) && $get['status']) ? true : false,
			'code'   => isset($get['code']) ? $get['code'] : null,
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