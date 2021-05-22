<?php
namespace content_smsapp\conversation;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Conversation"));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));


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
			'all'      => ['count' => a($conversationStat, 'all'), 'title' => T_("All")],
			'awaiting' => ['count' => a($conversationStat, 'awaiting'), 'title' => T_("Awaiting to answer")],
			'answered' => ['count' => a($conversationStat, 'answered'), 'title' => T_("Answered")],
		];

		\dash\data::myLinks($myLinks);

		return;












































		if(\dash\request::get('recommend') === 'yes')
		{
			$args['s_sms.recommend_id']  = ['IS NOT ', 'NULL'];
			$args['s_sms.receivestatus'] = 'awaiting';
			$args['s_sms.answertext']    = ['IS ', 'NULL'];


			// s_group.analyze = 1 AND

			$smsgroup = \lib\db\sms::get_recommend_group($countArgs);

			\dash\data::groupList($smsgroup);

			if(\dash\request::get('recommend_id'))
			{
				$answer_list = \lib\app\sms::answer_list(\dash\request::get('recommend_id'));
				\dash\data::answerList($answer_list);
			}
			else
			{
				$args['s_group.analyze']     = 1;
			}

		}

		$get = \dash\request::get();
		unset($get['page']);
		\dash\data::myUrlGet($get);
		if(!$get)
		{
			$args['s_sms.receivestatus'] = 'awaiting';
			$args['s_sms.recommend_id']  = null;
			$args['s_sms.group_id']      = null;
			$args['s_sms.answertext']    = null;
		}

		$startdate = null;
		$enddate   = null;

		$get_date_url = [];
		if(\dash\request::get('startdate'))
		{
			$startdate                 = \dash\request::get('startdate');
			$get_date_url['startdate'] = $startdate;
			$startdate                 = \dash\utility\convert::to_en_number($startdate);

			if(\dash\utility\jdate::is_jalali($startdate))
			{
				$startdate = \dash\utility\jdate::to_gregorian($startdate);
			}
			\dash\data::startdateEn($startdate);
		}


		if(\dash\request::get('enddate'))
		{
			$enddate                 = \dash\request::get('enddate');
			$get_date_url['enddate'] = $enddate;
			$enddate                 = \dash\utility\convert::to_en_number($enddate);
			if(\dash\utility\jdate::is_jalali($enddate))
			{
				$enddate = \dash\utility\jdate::to_gregorian($enddate);
			}
			\dash\data::enddateEn($enddate);
		}


		if($startdate && $enddate)
		{
			$args['1.1'] = [" = 1.1 ", " AND DATE(s_sms.datecreated) >= DATE('$startdate') AND DATE(s_sms.datecreated) <= DATE('$enddate')  "];
		}
		elseif($startdate)
		{
			$args['DATE(s_sms.datecreated)'] = [">=", " DATE('$startdate') "];
		}
		elseif($enddate)
		{
			$args['DATE(s_sms.datecreated)'] = ["<=", " DATE('$enddate') "];
		}


		$search_string = \dash\request::get('q');

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('receivestatus'))
		{
			$args['receivestatus']     = \dash\request::get('receivestatus');
			$filterArray[T_('receivestatus')] = \dash\request::get('receivestatus') === 'skip' ? 'archive' : \dash\request::get('receivestatus');
		}

		if(\dash\request::get('sendstatus'))
		{
			$args['sendstatus']     = \dash\request::get('sendstatus');
			$filterArray[T_('sendstatus')] = \dash\request::get('sendstatus');
		}

		if(\dash\request::get('fromnumber'))
		{
			$args['fromnumber']     = \dash\request::get('fromnumber');
			$filterArray[T_('fromnumber')] = \dash\request::get('fromnumber');
		}


		//if(\dash\request::get('togateway'))
		{
			//$args['togateway']     = \dash\request::get('togateway');
			//$filterArray[T_('togateway')] = \dash\request::get('togateway');
		}

		//if(\dash\request::get('togateway'))
		{
			//$args['togateway']     = \dash\request::get('togateway');
			//$filterArray[T_('togateway')] = \dash\request::get('togateway');
		}

		if(\dash\request::get('fromgateway'))
		{
			$args['fromgateway']     = \dash\request::get('fromgateway');
			$filterArray[T_('fromgateway')] = \dash\request::get('fromgateway');
		}

		if(\dash\request::get('group_id'))
		{
			$args['group_id']     = \dash\request::get('group_id');
			$filterArray[T_('group_id')] = \dash\request::get('group_id');
		}

		if(\dash\request::get('recommend_id'))
		{
			$args['recommend_id']     = \dash\request::get('recommend_id');
			$filterArray[T_('recommend_id')] = \dash\request::get('recommend_id');
		}

		if(\dash\request::get('tonumber'))
		{
			$args['tonumber']     = \dash\request::get('tonumber');
			$filterArray[T_('tonumber')] = \dash\request::get('tonumber');
		}

		if(\dash\request::get('type'))
		{
			$args['type']     = \dash\request::get('type');
			$filterArray[T_('type')] = \dash\request::get('type');
		}

		if(\dash\request::get('grouprecommend') && is_numeric(\dash\request::get('grouprecommend')))
		{
			$grouprecommend = intval(\dash\request::get('grouprecommend'));

			$args['3.3'] = ['= 3.3 AND ', " (s_sms.group_id = $grouprecommend OR s_sms.recommend_id = $grouprecommend) "];
		}

		$export = false;
		if(\dash\request::get('export') === '1')
		{
			$export = true;
			$args['pagenation'] = false;
			unset($args['limit']);
		}

		if(\dash\temp::get('no-limit'))
		{
			$args['pagenation'] = false;
			unset($args['limit']);
		}

		$dataTable = \lib\app\sms::list($search_string, $args);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_sms', 'data' => $dataTable]);
		}

		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\sms::$sort_field, \dash\url::that()));

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

		$status_count = \dash\session::get('sms_count_stat');
		// if(!$status_count)
		{
			$status_count = \lib\app\sms::status_sms_count($countArgs);
			\dash\session::set('sms_count_stat', $status_count, null, (60*5));
		}
		\dash\data::statusCount($status_count);

		\dash\data::sysStatus(\lib\app\sms::status());

		\dash\data::autoPanelAnswer(\lib\app\sms::is_auto_panel_answer());
		\dash\data::maxLimit(self::check_max_limit($child));


		$smsgroup = \lib\db\smsgroup::get(['1.1' => ["=", "1.1"]]);
		\dash\data::allGroupList($smsgroup);

		if(\dash\data::statusCount_lastconnected())
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_("Last update")." ". \dash\datetime::fit(date("Y-m-d H:i:s" , \dash\data::statusCount_lastconnected()), 'Y/m/d H:i:s') );
		}

	}
}
?>
