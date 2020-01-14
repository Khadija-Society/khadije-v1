<?php
namespace content_agent\servant\send;


class model
{
	public static function post()
	{

		$post =
		[
			'place_id'  => \dash\request::post('place'),
			'startdate' => \dash\request::post('startdate'),
			'enddate'   => \dash\request::post('enddate'),
			'job'       => \dash\request::get('job'),
			'city'      => \dash\request::get('city'),
			'user_id'   => \dash\request::get('user'),
		];

		\lib\app\send::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>