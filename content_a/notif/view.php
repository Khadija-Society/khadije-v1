<?php
namespace content_a\notif;


class view
{
	public static function config()
	{


		\dash\data::page_title(T_('Notification'));
		\dash\data::page_desc(T_('Allow to set notification to user'));
		\dash\data::page_pictogram('bullhorn');


	}
}
?>