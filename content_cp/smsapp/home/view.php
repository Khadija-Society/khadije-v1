<?php
namespace content_cp\smsapp\home;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Sms Analyzerr"));
		\dash\data::page_desc(T_("Syste for check and management sms"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

	}
}
?>