<?php
namespace content_hook\sms\home;

class controller
{
	public static function routing()
	{
		if(\dash\url::child() === 'a7cddcc2d626d3d4807e2cbd23129be3')
		{
			\dash\code::jsonBoom('Hi Hook!');
		}
		else
		{
			\dash\header::status(404, ':/');
		}
	}
}
?>