<?php
namespace content_protection\protectagent\home;


class view
{
	public static function config()
	{


		\dash\data::page_title(T_("Protect agent list"));

		\dash\data::page_pictogram('box');

		\dash\data::badge_link(\dash\url::this(). '/add');
		\dash\data::badge_text(T_('Add new protect agent'));


		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$filterArgs = [];
		$args =
		[
			'sort'       => \dash\request::get('sort'),
			'order'      => \dash\request::get('order'),
			'pagenation' => false,
		];

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		if(\dash\request::get('status'))
		{
			$args['protection_agent.status'] = \dash\request::get('status');
			$filterArgs['status'] = \dash\request::get('status');
		}

		if(\dash\request::get('type'))
		{
			$args['protection_agent.type'] = \dash\request::get('type');
			$filterArgs['type'] = \dash\request::get('type');
		}


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectagent::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectagent::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);


	}
}
?>