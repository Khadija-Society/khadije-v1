<?php
namespace content_cp;

class controller
{
	public static function routing()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::base(). '/enter');
			return;
		}

		if(!\dash\permission::access('cp'))
		{
			\dash\header::status(403, T_("Access denied"));
		}
	}
}
?>
