<?php
namespace content_a\group\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new group request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have group to holy places'));

		\dash\data::badge_link(\dash\url::here(). '/group');
		\dash\data::badge_text(T_('check your group requests'));

		if(!\lib\app\travel::group_master_active('get'))
		{
			\dash\data::signupLocked(true);
		}
		else
		{
			\dash\data::cityplaceList(\lib\app\travel::group_active_city());

			\dash\data::tripTermsGroup_qom(\lib\app\travel::trip_get_terms('group', 'qom'));
			\dash\data::tripTermsGroup_mashhad(\lib\app\travel::trip_get_terms('group', 'mashhad'));
			\dash\data::tripTermsGroup_karbala(\lib\app\travel::trip_get_terms('group', 'karbala'));
		}

	}
}
?>
