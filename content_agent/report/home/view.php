<?php
namespace content_agent\report\home;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Report"));
		\dash\data::page_desc(T_("System for check and management sms"));
		\dash\data::badge_link(\dash\url::here(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to dashboard'));

		$answer_time = \lib\app\sms\report::answer_time();
		\dash\data::answerTime($answer_time);


		$chart              = [];
		$chart['servantType']      = \lib\app\send\report::chart_servant_status(\dash\request::get('city'));
		$chart['placeSend']      = \lib\app\send\report::chart_place_send(\dash\request::get('city'));
		$chart['lastYear']    = \lib\app\send\report::lastYear(\dash\request::get('city'));



		\dash\data::myChart($chart);

	}
}
?>