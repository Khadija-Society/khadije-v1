<?php
namespace content_a\consulting\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of your consulting request"));
		\dash\data::page_desc(T_('You can check your last request and cancel them or add new request'));

		\dash\data::badge_link(\dash\url::here(). '/consulting/request');
		\dash\data::badge_text(T_('register for new consulting request'));


		\dash\data::serviceList(\lib\app\service::user_serviceList('consulting'));

		if(!\dash\data::serviceList() || empty(\dash\data::serviceList()))
		{
			\dash\redirect::to(\dash\url::here().'/consulting/request');
			return;
		}
	}
}
?>
