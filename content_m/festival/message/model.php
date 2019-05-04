<?php
namespace content_m\festival\message;


class model
{
	public static function post()
	{
		$post               = [];
		$post['messagesms'] = \dash\request::post('messagesms');
		$post['message']    = \dash\request::post('message') ? $_POST['message'] : null;
		$result             = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
