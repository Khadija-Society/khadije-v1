<?php
namespace content_hook\sms;

class view
{
	public static function config()
	{
		\dash\code::jsonBoom('Hi Hook!');
	}
}
?>