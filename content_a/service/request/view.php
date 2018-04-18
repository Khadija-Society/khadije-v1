<?php
namespace content_a\service\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new service request"). ' | '. T_('Step 1'));
		\dash\data::page_desc(T_('in 3 simple step register your request for have service to holy places'));

		\dash\data::badge_link(\dash\url::here(). '/service');
		\dash\data::badge_text(T_('check your service requests'));

		\dash\data::serviceNeedList(\lib\db\needs::get(['type' => 'expertise', 'status' => 'enable']));

	}
}
?>
