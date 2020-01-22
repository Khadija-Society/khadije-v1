<?php
namespace content_a\servant\home;


class view
{
	public static function config()
	{


		\dash\data::page_title(T_('Servant'));

		\dash\data::page_pictogram('atom');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));


		$myList = \lib\app\send::myList(\dash\user::id());
		\dash\data::myList($myList);

		$myListReport = \lib\app\send::myListReport(\dash\user::id());
		\dash\data::myListReport($myListReport);



	}
}
?>