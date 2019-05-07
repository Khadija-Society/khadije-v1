<?php
namespace content_smsapp\report;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Report"));
		\dash\data::page_desc(T_("System for check and management sms"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));


		$chart = \lib\app\sms::chart();
		\dash\data::masterChart($chart);

	}
}
?>