<?php
namespace content_agent\send\home;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantView');
		\dash\data::page_title("تاریخچه کاروان‌های اعزام شده");


		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::here(). '/servant/sortlist'. \dash\data::xCityStart());
		\dash\data::badge_text(T_('Add new send'));

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
			$args['order'] = 'desc';
		}


		if(!$args['sort'])
		{
			$args['sort'] = 'startdate';
		}

		if(\dash\request::get('job'))
		{
			$args['agent_send.job'] = \dash\request::get('job');
			$filterArgs['Job'] = \dash\request::get('job');
		}


		if(\dash\request::get('city'))
		{
			$args['agent_send.city'] = \dash\request::get('city');

		}



		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\send::$sort_field, \dash\url::this());
		$dataTable = \lib\app\send::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);



	}
}
?>