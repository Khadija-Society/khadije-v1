<?php
namespace content_smsapp\report\home;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Report"));
		\dash\data::page_desc(T_("System for check and management sms"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$answer_time = \lib\app\sms\report::answer_time();
		\dash\data::answerTime($answer_time);


		$chart            = [];
		$chart['master']  = \lib\app\sms::chart();
		$chart['receive'] = \lib\app\sms\report::chart_receivestatus();
		$chart['send']    = \lib\app\sms\report::chart_sendstatus();

		\dash\data::myChart($chart);

	}
}
?>