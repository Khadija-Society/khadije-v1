<?php
namespace content_a\advice\request;


class controller
{
	public static function routing()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::base(). '/enter');
			return;
		}
	}
}
?>
