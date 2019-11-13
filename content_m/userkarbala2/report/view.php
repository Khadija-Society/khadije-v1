<?php
namespace content_m\userkarbala2\report;


class view
{
	public static function config()
	{
		\dash\permission::access('koyeMohebbat');

		\dash\data::page_pictogram('chart');

		\dash\data::page_title('ثبت‌نامی‌های کربلا - برنامه کوی محبت');
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::this());



		$subchild = \dash\url::subchild();
		switch ($subchild)
		{
			case 'provincelist':
				$dataTable = \lib\app\karbala2user::chart_province_list();
				\dash\data::dataTable($dataTable);

				break;

			case 'map':
				\dash\data::include_highcharts(false);
				$chartProvinceData = \lib\app\karbala2user::chart_province();
				\dash\data::chartProvinceData($chartProvinceData);
				break;

			default:
				$ReportDailyChart = \lib\app\karbala2user::daily_chart();
				\dash\data::ReportDailyChart($ReportDailyChart);
				break;
		}

	}
}
?>
