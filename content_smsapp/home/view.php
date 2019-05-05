<?php
namespace content_smsapp\home;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Sms Analyzer"));
		\dash\data::page_desc(T_("System for check and management sms"));


		$chart = \lib\app\sms::chart();

		$args =
		[
			'order' => 's_sms.id',
			'sort'  => 'desc',
			's_group.type' => ['!=', "'family'"],
			'limit' => 6
		];

		$lastSms = \lib\app\sms::list(null, $args);

		\dash\data::lastSms($lastSms);


	}
}
?>