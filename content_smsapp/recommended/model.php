<?php
namespace content_smsapp\recommended;


class model
{
	public static function post()
	{
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
