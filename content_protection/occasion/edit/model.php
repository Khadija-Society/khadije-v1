<?php
namespace content_protection\occasion\edit;


class model
{
	public static function post()
	{


		$post =
		[
			'title'     => \dash\request::post('title'),
			'subtitle'  => \dash\request::post('subtitle'),
			'type'      => \dash\request::post('type'),
			'startdate' => \dash\request::post('startdate'),
			'expiredate'   => \dash\request::post('expiredate'),
			'desc'      => \dash\request::post('desc'),
			'status'    => \dash\request::post('status'),
		];


		\lib\app\occasion::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>