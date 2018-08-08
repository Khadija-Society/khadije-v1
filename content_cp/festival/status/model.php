<?php
namespace content_cp\festival\status;


class model
{
	public static function post()
	{
		$post            = [];
		$post['status'] = \dash\request::post('status');

		$result            = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
