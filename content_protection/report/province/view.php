<?php
namespace content_protection\report\province;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Agent registered"));

		\dash\data::page_pictogram('chart');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		\dash\data::include_highcharts(false);
		$reportDetail = \lib\app\protectionreport::province();
		\dash\data::reportDetail($reportDetail);

	}
}
?>