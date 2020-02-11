<?php
namespace content_lottery\user\report;


class view
{
	public static function config()
	{


		\dash\data::page_pictogram('chart');

		\dash\data::page_title('ثبت‌نامی‌های '. \dash\data::myLottery_title());
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::here());



		$subchild = \dash\url::subchild();
		switch ($subchild)
		{
			case 'provincelist':
				$dataTable = \lib\app\lottery_user::chart_province_list(\dash\data::myLotteryId());
				\dash\data::dataTable($dataTable);

				break;

			case 'map':
				\dash\data::include_highcharts(false);
				$chartProvinceData = \lib\app\lottery_user::chart_province(\dash\data::myLotteryId());
				\dash\data::chartProvinceData($chartProvinceData);
				break;

			default:
				$ReportDailyChart = \lib\app\lottery_user::daily_chart(\dash\data::myLotteryId());
				\dash\data::ReportDailyChart($ReportDailyChart);
				break;
		}

	}
}
?>
