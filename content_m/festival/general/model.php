<?php
namespace content_m\festival\general;


class model
{
	public static function post()
	{
		$post             = [];
		$post['title']    = \dash\request::post('title');
		$post['subtitle'] = \dash\request::post('subtitle');
		$post['slug']     = \dash\request::post('slug');
		$post['desc']     = \dash\request::post('desc');
		$post['student']  = \dash\request::post('student');

		$result           = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
