<?php
namespace content_agent\servant\sortlist;


class view
{
	public static function config()
	{

		\dash\data::page_title("لیست نوبت مبلغین");


		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::here(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));

		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$filterArgs = [];

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
			'limit' => 20
		];

		if(!$args['order'])
		{
			$args['order'] = 'ASC';
		}


		if(!$args['sort'])
		{
			$args['sort'] = 'sort';
		}

		$args['agent_servant.job'] = 'missionary';
		$args['sort_join'] = true;


		if(\dash\request::get('city'))
		{
			$args['agent_servant.city'] = \dash\request::get('city');

		}



		$sortLink  = \dash\app\sort::make_sortLink(['date', 'avg', 'count'], \dash\url::that());
		$dataTable = \lib\app\servant::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);



		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);



	}
}
?>