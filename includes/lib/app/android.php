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

		return $detail;
	}
}
?>