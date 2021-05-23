<?php
namespace content_smsapp\conversation;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('mail');

		\dash\data::page_title("سامانه مدیریت هوشمند پیامک |‌ پیامرس");



		$filterArray = [];
		$countArgs   = [];

		$args =
		[
			'order' => \dash\request::get('order'),
			'sort'  => \dash\request::get('sort'),
			'level'  => \dash\request::get('level'),
			'startdate'  => \dash\request::get('startdate'),
			'enddate'    => \dash\request::get('enddate'),
		];

		$q = \dash\request::get('q');

		$list = \lib\app\conversation\search::list($q, $args);

		\dash\data::dataTable($list);


		$conversationStat = \lib\app\conversation\get::stat();


		$myLinks =
		[
			'awaiting' => ['count' => a($conversationStat, 'awaiting'), 'title' => T_("Awaiting to answer"), 'default' => true],
			'all'      => ['count' => a($conversationStat, 'all'), 'title' => T_("All")],
		];

		\dash\data::myLinks($myLinks);

		\dash\data::sysStatus(\lib\app\sms::status());

		\dash\data::lastConnected(\lib\app\sms::lastconnected());

	}
}
?>
