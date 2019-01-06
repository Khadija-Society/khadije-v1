<?php
namespace lib\app;

class android
{
	public static function detail()
	{
		$detail                                = [];

		$detail['navigation']                  = [];
		$detail['navigation'][]                = ['title' => T_("Donate"), "url" => \dash\url::kingdom(). '/donate'];
		$detail['navigation'][]                = ['title' => T_("Home"), "url" => \dash\url::kingdom()];
		$detail['navigation'][]                = ['title' => T_("Trip"), "url" => \dash\url::kingdom(). '/trip'];

		$detail['app_version']                 = [];
		$detail['app_version']['code']         = 1;
		$detail['app_version']['title']        = "1.0";
		$detail['app_version']['content_text'] = null;
		$detail['app_version']['auto_hide']    = false;


		$detail['site']                        = \dash\url::site();
		$detail['kingdom']                     = \dash\url::kingdom();
		$detail['domain']                      = \dash\url::domain();
		$detail['name']                        = T_(\dash\option::config('site','title'));
		$detail['desc']                        = T_(\dash\option::config('site','desc'));
		$detail['logo']                        = \dash\url::static(). '/images/logo.png';


		$detail['intro']                 = [];
		$detail['intro']['btn']          = [];
		$detail['intro']['btn']['next']  = T_("Next");
		$detail['intro']['btn']['back']  = T_("Back");
		$detail['intro']['btn']['enter'] = T_("Enter");


		$detail['intro']['slide']        = [];
		$detail['intro']['slide'][] =
		[
			'title'      => T_("Intro 1"),
			'desc'       => T_("Description"),
			'background' => '#ffc960',
			'image'      => 'https://khadije.com/static/images/logo.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'      => T_("Intro 2"),
			'desc'       => T_("Description"). ' 2',
			'background' => '#6062ff',
			'image'      => 'https://khadije.com/static/images/logo.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'      => T_("Intro 3"),
			'desc'       => T_("Description"). ' 3',
			'background' => '#ff8caa',
			'image'      => 'https://khadije.com/static/images/logo.png',
		];

		$detail['intro']['slide'][] =
		[
			'title'      => T_("Intro 4"),
			'desc'       => T_("Description"). ' 4',
			'background' => '#60ff93',
			'image'      => 'https://khadije.com/static/images/logo.png',
		];

		return $detail;
	}
}
?>