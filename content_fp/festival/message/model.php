<?php
namespace content_fp\festival\message;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');
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
