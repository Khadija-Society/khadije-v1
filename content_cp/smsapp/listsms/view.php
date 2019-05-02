<?php
namespace content_cp\smsapp\listsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Sms list"));
		\dash\data::page_desc(T_("Sms list"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Dashboard'));


		$filterArray = [];

		$args =
		[
			'order' => \dash\request::get('order'),
			'sort'  => \dash\request::get('sort'),
			's_group.type' => ['!=', "'family'"],
		];

		if(\dash\permission::supervisor())
		{
			unset($args['s_group.type']);
		}

		$search_string = \dash\request::get('q');

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('reseivestatus'))
		{
			$args['reseivestatus']     = \dash\request::get('reseivestatus');
			$filterArray['reseivestatus'] = \dash\request::get('reseivestatus');
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

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\sms::$sort_field, \dash\url::that()));

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


		$smsgroup = \lib\db\smsgroup::get(['count' => ["IS NOT", "NULL AND `count` > 0 "]]);

		\dash\data::groupList($smsgroup);

		$status_count = \lib\db\sms::status_count($args);
		\dash\data::statusCount($status_count);


	}
}
?>
