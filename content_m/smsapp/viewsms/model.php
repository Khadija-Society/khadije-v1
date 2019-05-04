<?php
namespace content_m\smsapp\viewsms;


class model
{
	public static function post()
	{
		$post               = [];
		$post['group_id']   = \dash\request::post('group_id');
		$post['answertext'] = \dash\request::post('answertext');
		$post['sendstatus'] = 'awaiting';

		$result = \lib\app\sms::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
