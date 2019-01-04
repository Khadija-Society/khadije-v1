<?php
namespace lib\app;

class android
{
	public static function detail()
	{
		$detail                                = [];

		$detail['navigation']                  = [];
		$detail['navigation'][]                = ['title' => "pay", "url" => \dash\url::kingdom(). '/donate'];
		$detail['navigation'][]                = ['title' => "home", "url" => \dash\url::kingdom()];
		$detail['navigation'][]                = ['title' => "trip", "url" => \dash\url::kingdom(). '/trip'];

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


		return $detail;
	}
}
?>