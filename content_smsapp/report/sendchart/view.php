<?php
namespace content_smsapp\report\sendchart;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Report"));
		\dash\data::page_desc(T_("System for check and management sms"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));


		$chart              = [];
		$chart['master']    = \lib\app\sms::chart('2year');
		$chart['raw']    = \lib\app\sms::chart_raw('2year');

		\dash\data::myChart($chart);

	}
}
?>