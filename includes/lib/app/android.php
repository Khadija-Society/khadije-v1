<?php
namespace lib\app;

class android
{
	public static function detail()
	{
		$detail                 = [];

		$detail['navigation']   = [];
		$detail['navigation'][] = ['title' => "pay", "url" => \dash\url::kingdom(). '/donate'];
		$detail['navigation'][] = ['title' => "home", "url" => \dash\url::kingdom()];
		$detail['navigation'][] = ['title' => "trip", "url" => \dash\url::kingdom(). '/trip'];

		$detail['app_version']                 = [];
		$detail['app_version']['code']         = 1;
		$detail['app_version']['title']        = "1.0";
		$detail['app_version']['content_text'] = null;
		$detail['app_version']['auto_hide']    = false;


		return $detail;
	}
}
?>