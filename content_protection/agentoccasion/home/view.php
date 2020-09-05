<?php
namespace content_protection\agentoccasion\home;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Agent registered in this occasion"));

		\dash\data::page_pictogram('list');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$filterArgs  = [];
		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'       => \dash\request::get('sort'),
			'order'      => \dash\request::get('order'),

		];

		if(\dash\request::get('id'))
		{
			$args['protection_occasion_id'] = \dash\coding::decode(\dash\request::get('id'));
			$filterArgs[T_("Occasion")] = '';
		}


		if(\dash\request::get('status'))
		{
			$args['protection_agent_occasion.status'] = \dash\request::get('status');
			$filterArgs[T_("Status")] = \dash\request::get('status');
		}

		if(\dash\request::get('agent'))
		{
			$args['protection_agent_id'] = \dash\coding::decode(\dash\request::get('agent'));
			$filterArgs[T_("Agent")] = '';
		}

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectionagentoccasion::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectionagentoccasion::list(\dash\request::get('q'), $args);


		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);


	}
}
?>