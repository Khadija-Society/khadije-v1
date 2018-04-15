<?php
namespace content_a\service\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of your service request"));
		\dash\data::page_desc(T_('You can check your last request and cancel them or add new request'));

		\dash\data::badge_link(\dash\url::here(). '/service/request');
		\dash\data::badge_text(T_('register for new service request'));


		\dash\data::serviceList(\lib\app\service::user_serviceList());

		if(!\dash\data::serviceList() || empty(\dash\data::serviceList()))
		{
			\dash\redirect::to(\dash\url::here().'/service/request');
			return;
		}
	}
}
?>
