<?php
namespace content_smsapp\conversation;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('mail');

		\dash\data::page_title("سامانه مدیریت هوشمند پیامک |‌ پیامرس");



		$get_balance = \dash\session::get('sms_panel_detail');
		if(!$get_balance)
		{
			$default =
			[
				'remaincredit' => null,
				'expiredate'   => null,
				'type'         => 'Unknow',
			];
			$get_balance = \dash\utility\sms::info();


			if(isset($get_balance['entries']) && is_array($get_balance['entries']))
			{
				$get_balance = array_merge($default, $get_balance['entries']);
			}

			\dash\session::set('sms_panel_detail', $get_balance, null, (60 * 1));
		}

		\dash\data::SMSbalance($get_balance);



		$filterArray = [];
		$countArgs   = [];

		$args =
		[
			'order'     => \dash\request::get('order'),
			'sort'      => \dash\request::get('sort'),
			'level'     => \dash\request::get('level'),
			'startdate' => \dash\request::get('startdate'),
			'enddate'   => \dash\request::get('enddate'),
			'group_id'   => \dash\request::get('group_id'),
		];

		if(array_key_exists('group_id', $_GET) && !\dash\request::get('group_id'))
		{
			\dash\data::withoutGroupSelected(true);
			$args['group_id'] = false;
		}

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

		$currentStatInGroup = \dash\temp::get('currentStatInGroup');
		if(!is_array($currentStatInGroup))
		{
			$currentStatInGroup = [];
		}

		\dash\data::currentStatInGroup($currentStatInGroup);

		\dash\data::smsmAppFullTextSarch(\dash\temp::get('smsmAppFullTextSarch'));

		if(!\dash\temp::get('smsmAppFullTextSarch'))
		{
			$myLinks =
			[
				'awaiting' => ['count' => 0, 'title' => T_("Awaiting to answer"), 'default' => true],
				'all'      => ['count' => 0, 'title' => T_("All")],
				'answered' => ['count' => 0, 'title' => T_("Answered"), 'no_link' => true],
			];

			\dash\data::myLinks($myLinks);
		}

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
