<?php
namespace content_smsapp\dashboard;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Sms Analyzer"));
		\dash\data::page_desc(T_("System for check and management sms"));


		// $chart = \lib\app\sms::chart('month');
		// \dash\data::masterChart($chart);

		$args =
		[
			'order'      => 's_sms.id',
			'sort'       => 'desc',
			'pagenation' => false,
			'limit'      => 6
		];

		$lastSms = \lib\app\sms::list(null, $args);

		\dash\data::lastSms($lastSms);

		$dashboardDetail = \lib\app\sms::dashboard_detail();
		\dash\data::dashboardDetail($dashboardDetail);


	}
}
?>