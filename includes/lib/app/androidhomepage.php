<?php
namespace lib\app;

class androidhomepage
{
	private static function addr()
	{
		return __DIR__.'/androidhomepage.me.json';
	}

	public static function set($_args)
	{
		$old = self::get();
		$setting =
		[

			'firstbaner'     => (array_key_exists('firstbaner', $_args) && $_args['firstbaner']) ? true : null,
			'firstbaner_url' => array_key_exists('firstbaner_url', $_args) ? $_args['firstbaner_url'] : null,
			'link_1_status'  => (array_key_exists('link_1_status', $_args) && $_args['link_1_status']) ? true : null,
			'link_1_url'     => array_key_exists('link_1_url', $_args) ? $_args['link_1_url'] : null,
			'link_2_status'  => (array_key_exists('link_2_status', $_args) && $_args['link_2_status']) ? true : null,
			'link_2_url'     => array_key_exists('link_2_url', $_args) ? $_args['link_2_url'] : null,
			'link_3_status'  => (array_key_exists('link_3_status', $_args) && $_args['link_3_status']) ? true : null,
			'link_3_url'     => array_key_exists('link_3_url', $_args) ? $_args['link_3_url'] : null,
			'link_4_status'  => (array_key_exists('link_4_status', $_args) && $_args['link_4_status']) ? true : null,
			'link_4_url'     => array_key_exists('link_4_url', $_args) ? $_args['link_4_url'] : null,

		];


		$firstbaner_image = \dash\app\file::upload_quick('firstbaner_image');
		if($firstbaner_image)
		{
			$setting['firstbaner_image'] = $firstbaner_image;
		}
		else
		{
			$setting['firstbaner_image'] = \dash\get::index($old, 'firstbaner_image');
		}

		$link_1_image = \dash\app\file::upload_quick('link_1_image');
		if($link_1_image)
		{
			$setting['link_1_image'] = $link_1_image;
		}
		else
		{
			$setting['link_1_image'] = \dash\get::index($old, 'link_1_image');
		}

		$link_2_image = \dash\app\file::upload_quick('link_2_image');
		if($link_2_image)
		{
			$setting['link_2_image'] = $link_2_image;
		}
		else
		{
			$setting['link_2_image'] = \dash\get::index($old, 'link_2_image');
		}

		$link_3_image = \dash\app\file::upload_quick('link_3_image');
		if($link_3_image)
		{
			$setting['link_3_image'] = $link_3_image;
		}
		else
		{
			$setting['link_3_image'] = \dash\get::index($old, 'link_3_image');
		}

		$link_4_image = \dash\app\file::upload_quick('link_4_image');
		if($link_4_image)
		{
			$setting['link_4_image'] = $link_4_image;
		}
		else
		{
			$setting['link_4_image'] = \dash\get::index($old, 'link_4_image');
		}

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

		return $get;
	}



}
?>