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
			'limit'      => 6,
			's_sms.platoon'    => \lib\app\platoon\tools::get_index_locked(),

		];

		$lastSms = \lib\app\sms::list(null, $args);

		\dash\data::lastSms($lastSms);

		$dashboardDetail = \lib\app\sms::dashboard_detail(null, \lib\app\platoon\tools::get_index_locked());
		\dash\data::dashboardDetail($dashboardDetail);


	}
}
?>