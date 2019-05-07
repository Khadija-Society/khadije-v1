<?php
namespace content_smsapp\viewsms;


class model
{
	public static function post()
	{
		$post                  = [];
		$post['group_id']      = \dash\request::post('group_id');
		$post['answertext']    = \dash\request::post('answertext');
		$post['sendstatus']    = 'awaiting';
		$post['dateanswer']    = date("Y-m-d H:i:s");
		$post['receivestatus'] = 'answerready';

		$result = \lib\app\sms::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{

			$update_file                 = [];
			$update_file['last_update']  = date("Y-m-d H:i:s");
			$update_file['last_send_id'] = \dash\coding::decode(\dash\request::get('id'));

			\lib\app\sms::setting_file($update_file);

			\dash\redirect::pwd();
		}
	}
}
?>
