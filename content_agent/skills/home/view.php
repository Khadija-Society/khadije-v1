<?php
namespace content_agent\skills\home;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Skills list"));


		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::this(). '/add'. \dash\data::xCityStart());
		\dash\data::badge_text(T_('Add new skills'));

		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'ASC';
		}


		if(!$args['sort'])
		{
			$args['sort'] = 'sort';
		}

		if(\dash\request::get('status'))
		{
			$args['status'] = \dash\request::get('status');
		}

		// $args['pagenation'] = false;
		$args['limit'] = 20;


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\skills::$sort_field, \dash\url::this());
		$dataTable = \lib\app\skills::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['pagenation']);
		unset($check_empty_datatable['limit']);
		unset($check_empty_datatable['order']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);



	}
}
?>