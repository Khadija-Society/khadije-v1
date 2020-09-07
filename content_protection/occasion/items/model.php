<?php
namespace content_protection\occasion\items;


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
			'title'       => \dash\request::post('dtitle'),
			'price'       => \dash\request::post('price'),
			'desc'        => \dash\request::post('ddesc'),

		];

		\lib\app\occasion::add_detail($post, \dash\request::get('id'));


		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>