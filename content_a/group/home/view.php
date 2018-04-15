<?php
namespace content_a\group\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of your group request"));
		\dash\data::page_desc(T_('You can check your last request and cancel them or add new request'));

		\dash\data::badge_link(\dash\url::here(). '/group/request');
		\dash\data::badge_text(T_('register for new group request'));


		\dash\data::groupList(\lib\app\travel::user_travel_list('group'));

		if(!\dash\data::groupList() || empty(\dash\data::groupList()))
		{
			\dash\redirect::to(\dash\url::here().'/group/request');
			return;
		}
	}
}
?>
