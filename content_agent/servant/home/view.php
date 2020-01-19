<?php
namespace content_agent\servant\home;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantView');
		\dash\data::page_title(T_("Servant list"));


		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::this(). '/add'. \dash\data::xCityStart());
		\dash\data::badge_text(T_('Add new servant'));

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
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}


		if(!$args['sort'])
		{
			$args['sort'] = 'sort';
		}

		if(\dash\request::get('job'))
		{
			$args['agent_servant.job'] = \dash\request::get('job');
			$filterArgs['Job'] = \dash\request::get('job');
		}


		if(\dash\request::get('city'))
		{
			$args['agent_servant.city'] = \dash\request::get('city');

		}



		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\servant::$sort_field, \dash\url::this());
		$dataTable = \lib\app\servant::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);



		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);



	}
}
?>