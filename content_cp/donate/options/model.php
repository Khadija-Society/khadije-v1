<?php
namespace content_cp\donate\options;


class model
{

	public static function post()
	{
		if(\dash\request::post('type') === 'delete' && \dash\request::post('key'))
		{
			if(\lib\app\donate::remove_way(\dash\request::post('key')))
			{
				\dash\notif::warn(T_("The way successfully removed"));
			}
			else
			{
				return;
			}
		}
		else
		{
			$way = \dash\request::post('way');

			\lib\app\donate::set_way($way);

			\dash\notif::ok(T_("Way successfully added"));
		}

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
