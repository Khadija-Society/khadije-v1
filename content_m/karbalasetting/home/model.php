<?php
namespace content_m\karbalasetting\home;


class model
{
	public static function post()
	{

		\dash\permission::access('mKarbalaSetting');

		\lib\app\karbalasetting::set(\dash\request::post());
		\dash\redirect::pwd();

	}
}
?>