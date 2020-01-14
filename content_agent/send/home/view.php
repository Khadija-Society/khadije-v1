<?php
namespace content_agent\send\home;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantView');
		\dash\data::page_title(T_("Servant list"));


		\dash\data::page_pictogram('tools');

		\dash\data::badge_link(\dash\url::here(). '/servant');
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
		];

		if(!$args['order'])
		{
			$args['order'] = 'ASC';
		}


		if(!$args['sort'])
		{
			$args['sort'] = 'sort';
		}

		if(\dash\request::get('job'))
		{
			$args['agent_send.job'] = \dash\request::get('job');
			$filterArgs['Job'] = \dash\request::get('job');
		}


		if(\dash\request::get('city'))
		{
			$args['agent_send.city'] = \dash\request::get('city');
			$filterArgs['City'] = \dash\request::get('city');
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