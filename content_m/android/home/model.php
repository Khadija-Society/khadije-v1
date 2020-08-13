<?php
namespace content_m\android\home;


class model
{
	public static function post()
	{

		\dash\permission::access('mhomevideo');

		\lib\app\androidhomepage::set(\dash\request::post());
		\dash\redirect::pwd();

	}
}
?>