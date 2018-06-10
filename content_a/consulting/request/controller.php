<?php
namespace content_a\consulting\request;


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
