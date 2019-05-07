<?php
namespace content_smsapp\listsms;


class model
{
	public static function post()
	{
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
