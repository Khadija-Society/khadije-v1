<?php
namespace content_m\report\home;


class view
{
	public static function config()
	{
		\dash\permission::access('cpReportView');

		\dash\data::page_pictogram('chart');

		\dash\data::page_title(T_('Report list'));
		\dash\data::page_desc(T_('Some financial reports for management.'));

		\dash\data::badge_text(T_('Back to dashboard'));
		\dash\data::badge_link(\dash\url::here());
	}
}
?>