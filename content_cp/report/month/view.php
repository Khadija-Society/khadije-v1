<?php
namespace content_cp\report\month;


class view
{
	public static function config()
	{
		\dash\permission::access('cpReportMonth');

		\dash\data::page_pictogram('chart');

		\dash\data::include_chart(true);

		\dash\data::page_title(T_('Report month'));
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back to report list'));
		\dash\data::badge_link(\dash\url::this());


		$result = \lib\app\report\month::monthly(\dash\request::get('sort'), \dash\request::get('order'));

		\dash\data::sortLink(\dash\app\sort::make_sortLink(['sum', 'date'], \dash\url::current()));


		if(isset($result['chart']))
		{
			\dash\data::ReportMonthlyChart($result['chart']);
		}

		if(isset($result['table']))
		{
			\dash\data::ReportMonthlyTable($result['table']);
		}

	}
}
?>
