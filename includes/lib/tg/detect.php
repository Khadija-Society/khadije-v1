<?php
namespace lib\tg;
use \dash\social\telegram\tg as bot;


class detect
{
	public static function run($_cmd)
	{
		return;
		if(bot::isInline())
		{
			// not yet
		}
		else
		{
			smsapp::detector($_cmd);
		}
	}
}
?>