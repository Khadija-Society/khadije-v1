<?php
namespace content_smsapp\conversation;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		if(\dash\request::get('calc') === 'all')
		{
			\dash\temp::set('calcRecord', true);
			$result            = \content_smsapp\conversation\view::config();
			\dash\code::jsonBoom($result);
		}

	}
}
?>
