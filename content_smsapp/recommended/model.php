<?php
namespace content_smsapp\recommended;


class model
{
	public static function post()
	{
		if(\dash\request::post('type') === 'setAnswer')
		{
			$answer_id    = \dash\request::post('answer_id');
			$recommend_id = \dash\request::post('recommend_id');
			\lib\app\sms::recommend_answer($recommend_id, $answer_id);
			\dash\notif::ok(T_("All message group saved"));
			\dash\redirect::pwd();
			return;
		}

		if(\dash\request::post('recommend') === 'invalid')
		{
			$post                 = [];
			$post['recommend_id'] = null;
			$result               = \lib\app\sms::edit($post, \dash\request::post('id'));
			\dash\redirect::pwd();
			return;
		}


		$status = \dash\request::post('status');

		if($status === 'change')
		{
			$myStatus = \lib\app\sms::status();
			if($myStatus)
			{
				$myStatus = \lib\app\sms::status(false);
			}
			else
			{
				$myStatus = \lib\app\sms::status(true);
			}

			\dash\redirect::pwd();
		}

	}
}
?>
