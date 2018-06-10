<?php
namespace content_a\advice\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new advice request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have advice'));

		\dash\data::badge_link(\dash\url::here(). '/advice');
		\dash\data::badge_text(T_('check your advice requests'));

		\dash\data::serviceNeedList(\lib\app\need::active_list('advice'));
	}
}
?>
