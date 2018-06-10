<?php
namespace content_a\consulting\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new consulting request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have consulting'));

		\dash\data::badge_link(\dash\url::here(). '/consulting');
		\dash\data::badge_text(T_('check your consulting requests'));

		\dash\data::serviceNeedList(\lib\app\need::active_list('consulting'));
	}
}
?>
