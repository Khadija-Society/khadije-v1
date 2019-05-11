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
		$countArgs   = [];

		$args =
		[
			'order'              => \dash\request::get('order'),
			'sort'               => \dash\request::get('sort'),
		];

		$child = \dash\url::child();

		if($child && \dash\utility\filter::mobile($child))
		{
			$args['s_sms.togateway']         = $child;
			$countArgs['s_sms.togateway']    = $child;
		}

		if(\dash\request::get('recommend') === 'yes')
		{
			$args['s_sms.recommend_id'] = ['IS NOT ', 'NULL'];
			$args['s_sms.sendstatus']   = ['IS ', 'NULL'];

			$smsgroup = \lib\db\sms::get_recommend_group($countArgs);

			\dash\data::groupList($smsgroup);

			if(\dash\request::get('recommend_id'))
			{
				$answer_list = \lib\app\sms::answer_list(\dash\request::get('recommend_id'));
				\dash\data::answerList($answer_list);
			}

		}


		if(!\dash\request::get())
		{
			$args['s_sms.receivestatus'] = 'awaiting';
		}

		$search_string = \dash\request::get('q');

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('receivestatus'))
		{
			$args['receivestatus']     = \dash\request::get('receivestatus');
			$filterArray[T_('receivestatus')] = \dash\request::get('receivestatus');
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


		if(\dash\request::get('togateway'))
		{
			$args['togateway']     = \dash\request::get('togateway');
			$filterArray[T_('togateway')] = \dash\request::get('togateway');
		}

		if(\dash\request::get('togateway'))
		{
			$args['togateway']     = \dash\request::get('togateway');
			$filterArray[T_('togateway')] = \dash\request::get('togateway');
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

		if(\dash\request::get('type'))
		{
			$args['type']     = \dash\request::get('type');
			$filterArray[T_('type')] = \dash\request::get('type');
		}

		$dataTable = \lib\app\sms::list($search_string, $args);

		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_m\view::make_sort_link(\lib\app\sms::$sort_field, \dash\url::that()));

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

		$status_count = \lib\app\sms::status_sms_count($countArgs);
		\dash\data::statusCount($status_count);

		\dash\data::sysStatus(\lib\app\sms::status());

	}
}
?>
