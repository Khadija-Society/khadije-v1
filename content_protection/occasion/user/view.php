<?php
namespace content_protection\occasion\user;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("List of people introduced in this occasion"));

		\dash\data::page_pictogram('list');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'       => \dash\request::get('sort'),
			'order'      => \dash\request::get('order'),
			'protection_occasion_id'      => \dash\coding::decode(\dash\request::get('id')),

		];

		if(\dash\request::get('agent'))
		{
			$args['protection_agent_id'] = \dash\coding::decode(\dash\request::get('agent'));
			if($args['protection_agent_id'])
			{
				$agentDetail = \lib\app\protectagent::get(\dash\request::get('agent'));
				\dash\data::agentDetail($agentDetail);
			}
		}

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectagentuser::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectagentuser::list(\dash\request::get('q'), $args);


		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['protection_occasion_id']);
		unset($check_empty_datatable['protection_agent_id']);

		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['pagenation']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>