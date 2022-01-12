<?php
namespace content_protection\occasion\agent;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Agent registered in this occasion"));

		\dash\data::page_pictogram('list');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		\dash\data::mediaTitle(\lib\app\protectionagentoccasion::field_list());
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
			// 'pagenation' => false,
		];

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectionagentoccasion::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectionagentoccasion::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['protection_occasion_id']);

		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['pagenation']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>