<?php
namespace content_protection\report\home;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Agent registered"));

		\dash\data::page_pictogram('chart');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$reportDetail = \lib\app\protectionreport::occasion_type();
		\dash\data::reportDetail($reportDetail);

	}
}
?>