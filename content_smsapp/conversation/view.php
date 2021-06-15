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
			'order'     => \dash\request::get('order'),
			'sort'      => \dash\request::get('sort'),
			'level'     => \dash\request::get('level'),
			'startdate' => \dash\request::get('startdate'),
			'enddate'   => \dash\request::get('enddate'),
		];

		$q = \dash\request::get('q');

		if(\dash\temp::get('calcRecord'))
		{
			$args['get_count_all'] = true;
			$args['level']         = \dash\temp::get('calcRecordLevel');
		}

		$list = \lib\app\conversation\search::list($q, $args);

		if(\dash\temp::get('calcRecord'))
		{
			return $list;
		}


		$conversationStat = \lib\app\conversation\get::stat();


		$myLinks =
		[
			'awaiting' => ['count' => a($conversationStat, 'awaiting'), 'title' => T_("Awaiting to answer"), 'default' => true],
			'all'      => ['count' => a($conversationStat, 'all'), 'title' => T_("All")],
			'answered' => ['count' => a($conversationStat, 'answered'), 'title' => T_("Answered"), 'no_link' => true],
		];

		\dash\data::myLinks($myLinks);

		\dash\data::sysStatus(\lib\app\sms::status());

		\dash\data::lastConnected(\lib\app\sms::lastconnected());

		$args =
		[
			'pagenation' => false,
			'type'       => 'number',
			'group_id'   => \content_smsapp\editgroup\controller::secret_group_id(true),
		];


		$load_all_secret_number = \lib\app\smsgroupfilter::list(null, $args);

		$load_all_secret_number = array_column($load_all_secret_number, 'number');

		foreach ($list as $key => $value)
		{
			if(isset($value['fromnumber']) && in_array($value['fromnumber'], $load_all_secret_number))
			{
				$list[$key]['lastmessage'] = 'secret message';
			}
		}


		\dash\data::dataTable($list);

		$all_get = \dash\request::get();
		unset($all_get['page']);
		\dash\data::requestGETWithoutPage($all_get);


	}
}
?>
