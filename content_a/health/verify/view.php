<?php
namespace content_a\health\verify;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new health request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have health'));

		\dash\data::badge_link(\dash\url::here(). '/health');
		\dash\data::badge_text(T_('check your health requests'));

	}
}
?>
