<?php
namespace content_m\smsapp\home;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Sms Analyzer"));
		\dash\data::page_desc(T_("System for check and management sms"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$chart = \lib\app\sms::chart();


	}
}
?>