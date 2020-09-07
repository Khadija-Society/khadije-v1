<?php
namespace content_protection\occasion\allowagent;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit occasion"));
		\dash\data::page_desc(T_('Edit name or description of this occasion or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());

		\dash\data::badge_text(T_('Back to list of occasion'));

		$id     = \dash\request::get('id');
		$result = \lib\app\occasion::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid occasion id"));
		}

		\dash\data::dataRow($result);

		\dash\data::dataDetail(\lib\app\occasion::get_detail(\dash\request::get('id')));

		$typeList = \lib\app\protectiontype::get_all();
		\dash\data::typeList($typeList);

		$occasionTypeList = \lib\app\protectiontype::get_all('occasiontype');
		\dash\data::occasionTypeList($occasionTypeList);

		$occasionType = \lib\app\protectiontype::occasion_type(\dash\request::get('id'));
		if(!is_array($occasionType))
		{
			$occasionType = [];
		}
		\dash\data::currentTypeID(array_column($occasionType, 'id'));
		\dash\data::occasionType($occasionType);





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

		$args['protection_agent.status'] = 'enable';



		if(\dash\request::get('type'))
		{
			$args['protection_agent.type'] = \dash\request::get('type');
			$filterArgs[T_('type')] = \dash\request::get('type');
		}

		if(\dash\request::get('city'))
		{
			$args['protection_agent.city'] = \dash\request::get('city');
			$filterArgs[T_('city')] = \dash\request::get('city');
		}


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectagent::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectagent::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);

		$get_allow = \lib\app\protectionagentoccasion::get_allow(\dash\request::get('id'));
		$allAgetnId = array_column($get_allow, 'protection_agent_id');
		\dash\data::AllAgentIdInThisOccasion($allAgetnId);


	}
}
?>