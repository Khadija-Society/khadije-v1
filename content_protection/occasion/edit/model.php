<?php
namespace content_protection\occasion\edit;


class model
{
	public static function post()
	{
		if(\dash\request::post('remove') === 'detail')
		{
			\lib\app\occasion::remove_detail(\dash\request::post('detail_id'));
			\dash\redirect::pwd();
			return;

		}

		$post =
		[
			'type_list'  => \dash\request::post('type_list'), // array
			'title'      => \dash\request::post('title'),
			'type'      => \dash\request::post('type'),
			'subtitle'   => \dash\request::post('subtitle'),
			'startdate'  => \dash\request::post('startdate'),
			'expiredate' => \dash\request::post('expiredate'),
			'desc'       => \dash\request::post('desc'),
			'status'     => \dash\request::post('status'),
		];


		\lib\app\occasion::edit($post, \dash\request::get('id'));
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>