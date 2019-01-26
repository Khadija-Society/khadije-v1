<?php
namespace content_cp\trip\add;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Add new trip"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::here(). '/trip');
		\dash\data::badge_text(T_('check your trip requests'));

		\dash\data::cityplaceList(\lib\app\travel::active_city());


	}
}
?>
