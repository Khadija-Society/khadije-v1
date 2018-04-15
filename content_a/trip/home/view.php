<?php
namespace content_a\trip\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of your trip request"));
		\dash\data::page_desc(T_('You can check your last request and cancel them or add new request'));

		\dash\data::badge_link(\dash\url::here(). '/trip/request');
		\dash\data::badge_text(T_('register for new trip request'));


		\dash\data::tripList(\lib\app\travel::user_travel_list('family'));

		if(!\dash\data::tripList() || empty(\dash\data::tripList()))
		{
			\dash\redirect::to(\dash\url::here().'/trip/request');
			return;
		}
	}
}
?>
