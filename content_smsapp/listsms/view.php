<?php
namespace content_smsapp\listsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Sms list"));
		\dash\data::page_desc(T_("Sms list"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));


		$filterArray = [];

		$args =
		[
			'order' => \dash\request::get('order'),
			'sort'  => \dash\request::get('sort'),
			// 's_group.type' => ['!=', "'family'"],
			// 's_sms.receivestatus' => ['!=', "'block'"],

		];

		// if(\dash\permission::supervisor())
		// {
		// 	unset($args['s_group.type']);
		// }

		$search_string = \dash\request::get('q');

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('receivestatus'))
		{
			$args['receivestatus']     = \dash\request::get('receivestatus');
			$filterArray['receivestatus'] = \dash\request::get('receivestatus');
		}

		if(\dash\request::get('sendstatus'))
		{
			$args['sendstatus']     = \dash\request::get('sendstatus');
			$filterArray['sendstatus'] = \dash\request::get('sendstatus');
		}

		if(\dash\request::get('fromnumber'))
		{
			$args['fromnumber']     = \dash\request::get('fromnumber');
			$filterArray['fromnumber'] = \dash\request::get('fromnumber');
		}

		if(\dash\request::get('togateway'))
		{
			$args['togateway']     = \dash\request::get('togateway');
			$filterArray['togateway'] = \dash\request::get('togateway');
		}

		if(\dash\request::get('fromgateway'))
		{
			$args['fromgateway']     = \dash\request::get('fromgateway');
			$filterArray['fromgateway'] = \dash\request::get('fromgateway');
		}

		if(\dash\request::get('type'))
		{
			$args['type']     = \dash\request::get('type');
			$filterArray['type'] = \dash\request::get('type');
		}

		$dataTable = \lib\app\sms::list($search_string, $args);

		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\sms::$sort_field, \dash\url::that()));

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


		$smsgroup = \lib\db\smsgroup::get(['count' => ["IS NOT", "NULL AND `count` > 0 "]]);

		\dash\data::groupList($smsgroup);

		$status_count1 = \lib\db\sms::status_count($args, 'receivestatus');
		$status_count2 = \lib\db\sms::status_count($args, 'sendstatus');

		\dash\data::statusCount_receive($status_count1);
		\dash\data::statusCount_send($status_count2);


	}
}
?>
