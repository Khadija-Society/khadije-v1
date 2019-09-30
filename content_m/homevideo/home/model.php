<?php
namespace content_m\homevideo\home;


class model
{
	public static function post()
	{

		\dash\permission::access('mhomevideo');

		\lib\app\homevideo::set(\dash\request::post());
		\dash\redirect::pwd();

	}
}
?>