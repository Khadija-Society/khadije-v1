<?php
namespace content_a\representation\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new representation request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have representation'));

		\dash\data::badge_link(\dash\url::here(). '/representation');
		\dash\data::badge_text(T_('check your representation requests'));

		\dash\data::serviceNeedList(\lib\db\needs::get(['type' => 'representation', 'status' => 'enable']));

	}
}
?>
