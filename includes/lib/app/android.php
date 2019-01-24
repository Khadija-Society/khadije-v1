<?php
namespace lib\app;

class android
{

	public static function detail()
	{
		$detail = [];

		self::master_detail($detail);

		self::static_page($detail);

		self::navigation($detail);

		self::app_version($detail);

		self::intro($detail);


		return $detail;
	}



	private static function master_detail(&$detail)
	{
		$detail['site']                        = \dash\url::site();
		$detail['kingdom']                     = \dash\url::kingdom();
		$detail['domain']                      = \dash\url::domain();
		$detail['name']                        = T_(\dash\option::config('site','title'));
		$detail['desc']                        = T_(\dash\option::config('site','desc'));
		$detail['logo']                        = \dash\url::static(). '/images/logo.png';

	}


	private static function static_page(&$detail)
	{
		$detail['android_menu']                        = [];
		$detail['android_menu'][] =
		[
			'title' => T_("About"),
			'url'   => \dash\url::kingdom(). '/api/v5/about'
		];

		$detail['android_menu'][] =
		[
			'title' => T_("Contact"),
			'url'   => \dash\url::kingdom(). '/api/v5/contact'
		];

		$detail['android_menu'][] =
		[
			'title' => T_("Vision"),
			'url'   => \dash\url::kingdom(). '/api/v5/vision'
		];

		$detail['android_menu'][] =
		[
			'title' => T_("Mission"),
			'url'   => \dash\url::kingdom(). '/api/v5/mission'
		];

		$detail['android_menu'][] =
		[
			'title' => T_("Website"),
			'url'   => \dash\url::kingdom()
		];

	}


	private static function navigation(&$detail)
	{
		$detail['navigation']   = [];

		$detail['navigation'][] =
		[
			'title' => T_('Home'),
			'url'   => \dash\url::kingdom(). '/app/android',
			'icon'  => 'home',
		];

		// $detail['navigation'][] =
		// [
		// 	'title' => T_('Website'),
		// 	'url'   => \dash\url::kingdom(),
		// 	'icon'  => 'world',
		// ];

		$detail['navigation'][] =
		[
			'title' => T_('Delneveshte'),
			'url'   => \dash\url::kingdom(). '/delneveshte',
			'icon'  => 'delneveshte',
		];

		$detail['navigation'][] =
		[
			'title' => T_('Setting'),
			'url'   => 'setting',
			'icon'  => 'seting',
		];

		// if(\dash\language::current() === 'fa')
		// {
		// 	$detail['navigation'][] =
		// 	[
		// 		'title' => T_('Donate'),
		// 		'url'   => \dash\url::kingdom(). '/donate',
		// 		'icon'  => 'pay',
		// 	];
		// }
		// else
		// {
		// 	$detail['navigation'][] =
		// 	[
		// 		'title' => T_('Enter'),
		// 		'url'   => \dash\url::kingdom(). '/enter',
		// 		'icon'  => 'enter',
		// 	];
		// }




	}


	private static function app_version(&$detail)
	{
		$detail['app_version']                 = [];
		$detail['app_version']['code']         = 1;
		$detail['app_version']['title']        = '1.0';
		$detail['app_version']['content_text'] = null;
		$detail['app_version']['auto_hide']    = false;
	}


	private static function intro(&$detail)
	{
		$detail['intro']                 = [];

		$detail['intro']['btn']          = [];
		$detail['intro']['btn']['next']  = T_('Next');
		$detail['intro']['btn']['back']  = T_('Skip');
		$detail['intro']['btn']['enter'] = T_('Enter');


		$detail['intro']['slide']   = [];
		$detail['intro']['slide'][] =
		[
			'title'       => T_('Travel to Karbala'),
			'desc'        => T_('Executor of first pilgrimage to the Ahl al-Bayt | Karbala - Mashhad - Qom'),
			'background'  => '#ffffff',
			'title_color' => '#ffffff',
			'desc_color'  => '#ffffff',
			'image'       => 'https://khadije.com/files/1/92-fd6f59d2284353db98bdf32e2d6796c8.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'       => T_('Travel to Qom'),
			'desc'        => T_('Executor of first pilgrimage to the Ahl al-Bayt | Karbala - Mashhad - Qom'),
			'background'  => '#ffffff',
			'title_color' => '#ffffff',
			'desc_color'  => '#ffffff',
			'image'       => 'https://khadije.com/files/1/90-7de485580f96aefb3e1c70f445565028.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'       => T_('Travel to Mashhad'),
			'desc'        => T_('Executor of first pilgrimage to the Ahl al-Bayt | Karbala - Mashhad - Qom'),
			'background'  => '#ffffff',
			'title_color' => '#ffffff',
			'desc_color'  => '#ffffff',
			'image'       => 'https://khadije.com/files/1/91-b688f1d8b2ba6f076558b8d97bbc615e.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'       => T_('Khadije Charity'),
			'desc'        => T_('Executor of first pilgrimage to the Ahl al-Bayt | Karbala - Mashhad - Qom'),
			'background'  => '#ffffff',
			'title_color' => '#ffffff',
			'desc_color'  => '#ffffff',
			'image'       => 'https://khadije.com/files/1/431-22327c753b4d65d22873fc545e2dd7c1.png',
		];
	}
}
?>