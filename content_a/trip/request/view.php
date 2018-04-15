<?php
namespace content_a\trip\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new trip request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have trip to holy places'));
		\dash\data::badge_link(\dash\url::here(). '/trip');
		\dash\data::badge_text(T_('check your trip requests'));

		if(!\lib\app\travel::trip_master_active('get'))
		{
			\dash\data::signupLocked(true);
		}
		else
		{
			\dash\data::cityplaceList(\lib\app\travel::active_city());
		}

	}
}
?>
