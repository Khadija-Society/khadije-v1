<?php
namespace content_cp\options\cityplace;


class model
{

	public static function post()
	{
		\dash\permission::access('cpOptionCityPlace');
		if(\dash\request::post('type') === 'delete' && \dash\request::post('key'))
		{
			if(\lib\app\travel::remove_cityplace(\dash\request::post('key')))
			{
				\dash\notif::warn(T_("The city place successfully removed"));
			}
			else
			{
				return;
			}
		}
		else
		{
			\lib\app\travel::set_cityplace(\dash\request::post('city'), \dash\request::post('place'));

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("City place successfully added"));
			}
		}

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>
