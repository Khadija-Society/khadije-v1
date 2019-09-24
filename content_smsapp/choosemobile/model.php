<?php
namespace content_smsapp\choosemobile;


class model
{
	public static function post()
	{
		if(\dash\permission::supervisor())
		{
			$type = \dash\request::post('type');
			if($type === 'removeAll' && \dash\request::post('gateway') !== '989127522690')
			{
				$result = \lib\db\sms::removeAll(\dash\request::post('gateway'));
				if($result)
				{
					\dash\notif::ok("Ok");
					\dash\redirect::pwd();
				}
				else
				{
					\dash\notif::ok("Can not delete");
				}
			}

		}
	}
}
?>
