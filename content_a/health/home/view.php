<?php
namespace content_a\health\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of your health request"));
		\dash\data::page_desc(T_('You can check your last request and cancel them or add new request'));

		\dash\data::badge_link(\dash\url::here(). '/health/request');
		\dash\data::badge_text(T_('register for new health request'));


		\dash\data::serviceList(\lib\app\service::user_serviceList('health'));

		if(!\dash\data::serviceList() || empty(\dash\data::serviceList()))
		{
			\dash\redirect::to(\dash\url::here().'/health/request');
			return;
		}
	}
}
?>
