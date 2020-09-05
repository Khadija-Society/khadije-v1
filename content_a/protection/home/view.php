<?php
namespace content_a\protection\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("List of occasion"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$occasion = \lib\app\occasion::get_active_list();
		if(!is_array($occasion))
		{
			$occasion = [];
		}
		\dash\data::occasionList($occasion);


		$registeredOccasion = \lib\app\protectionagentoccasion::old_registered_occasion();

		$occasionID = [];

		if(is_array($registeredOccasion))
		{
			$occasionID = array_column($registeredOccasion, 'protection_occasion_id');
		}
		\dash\data::occasionID($occasionID);

		if(count($occasion) > count($occasionID))
		{
			\dash\data::haveUnregisteredOccasion(true);
		}

		\dash\data::registeredOccasion($registeredOccasion);


	}
}
?>
