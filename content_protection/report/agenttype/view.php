<?php
namespace content_protection\agentoccasion\allprice;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("All report of agent"));

		\dash\data::page_pictogram('list');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$filterArgs  = [];
		$summaryArgs = [];
		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'   => \dash\request::get('sort'),
			'order'  => \dash\request::get('order'),
			'total_price' => ['is', 'not null'],

		];

		$summaryArgs['total_price'] = ['is', 'not null'];

		$startdate = null;
		$enddate   = null;

		$get_date_url = [];
		if(\dash\request::get('startdate'))
		{
			$startdate                 = \dash\request::get('startdate');
			$get_date_url['startdate'] = $startdate;
			$startdate                 = \dash\utility\convert::to_en_number($startdate);

			if(\dash\utility\jdate::is_jalali($startdate))
			{
				$startdate = \dash\utility\jdate::to_gregorian($startdate);
			}
			\dash\data::startdateEn($startdate);


		}

		if(\dash\request::get('enddate'))
		{
			$enddate                 = \dash\request::get('enddate');
			$get_date_url['enddate'] = $enddate;
			$enddate                 = \dash\utility\convert::to_en_number($enddate);
			if(\dash\utility\jdate::is_jalali($enddate))
			{
				$enddate = \dash\utility\jdate::to_gregorian($enddate);
			}
			\dash\data::enddateEn($enddate);

		}


		if($startdate && $enddate)
		{
			$args['1.1'] = [" = 1.1 ", " AND DATE(protection_agent_occasion.paydate) >= '$startdate' AND DATE(protection_agent_occasion.paydate) <= '$enddate'  "];
			$summaryArgs['1.1'] = [" = 1.1 ", " AND DATE(protection_agent_occasion.paydate) >= '$startdate' AND DATE(protection_agent_occasion.paydate) <= '$enddate'  "];

		}
		elseif($startdate)
		{
			$args['DATE(protection_agent_occasion.paydate)'] = [">=", " '$startdate' "];
			$summaryArgs['DATE(protection_agent_occasion.paydate)'] = [">=", " '$startdate' "];
		}
		elseif($enddate)
		{
			$args['DATE(protection_agent_occasion.paydate)'] = ["<=", " '$enddate' "];
			$summaryArgs['DATE(protection_agent_occasion.paydate)'] = ["<=", " '$enddate' "];
		}



		if(\dash\request::get('occasiontarget'))
		{
			$args['join_type'] = true;
			$args['protection_occasion_type.type_id'] = \dash\coding::decode(\dash\request::get('occasiontarget'));
			$summaryArgs['protection_occasion_type.type_id'] = $args['protection_occasion_type.type_id'];
			$summaryArgs['join_type'] = true;
			$filterArgs[T_("Occasion target")] = '';
		}

		if(\dash\request::get('city'))
		{
			$args['protection_agent.city'] = \dash\request::get('city');
			$summaryArgs['protection_agent.city'] = $args['protection_agent.city'];
			$filterArgs[T_("City")] = \dash\request::get('city');
		}

		if(\dash\request::get('province'))
		{
			$args['protection_agent.province'] = \dash\request::get('province');
			$summaryArgs['protection_agent.province'] = $args['protection_agent.province'];
			$filterArgs[T_("City")] = \dash\request::get('province');
		}

		if(\dash\request::get('agenttype'))
		{
			$args['protection_agent.type'] = \dash\request::get('agenttype');
			$summaryArgs['protection_agent.type'] = $args['protection_agent.type'];
			$filterArgs[T_("Agent type")] = \dash\request::get('agenttype');
		}

		if(\dash\request::get('occasiontype'))
		{
			$args['protection_occasion.type'] = \dash\request::get('occasiontype');
			$summaryArgs['protection_occasion.type'] = $args['protection_occasion.type'];
			$filterArgs[T_("Occasion type")] = \dash\request::get('occasiontype');
		}

		if(\dash\request::get('id'))
		{
			$args['protection_occasion_id'] = \dash\coding::decode(\dash\request::get('id'));
			$summaryArgs['protection_occasion_id'] = $args['protection_occasion_id'];
			$filterArgs[T_("Occasion")] = '';
		}


		if(\dash\request::get('status'))
		{
			$args['protection_agent_occasion.status'] = \dash\request::get('status');
			$summaryArgs['protection_agent_occasion.status'] = $args['protection_agent_occasion.status'];
			$filterArgs[T_("Status")] = \dash\request::get('status');
		}

		if(\dash\request::get('agent'))
		{
			$args['protection_agent_id'] = \dash\coding::decode(\dash\request::get('agent'));
			$summaryArgs['protection_agent_id'] = $args['protection_agent_id'];
			$filterArgs[T_("Agent")] = '';
		}

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectionagentoccasion::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectionagentoccasion::list(\dash\request::get('q'), $args);

		$summaryDetail = \lib\app\protectionagentoccasion::summary(\dash\request::get('q'), $summaryArgs);
		\dash\data::summaryDetail($summaryDetail);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);


		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArgs);
		\dash\data::dataFilter($dataFilter);

		$agentType = \lib\app\protectiontype::get_all_full('agenttype');
		\dash\data::agentType($agentType);

		$occasionType = \lib\app\protectiontype::get_all_full('occasiontype');
		\dash\data::occasionType($occasionType);

		$occasionTarget = \lib\app\protectiontype::get_all_full('occasiontarget');
		\dash\data::occasionTarget($occasionTarget);


		$cityList    = \dash\utility\location\cites::$data;
		$proviceList = \dash\utility\location\provinces::key_list('localname');
		\dash\data::provinceList($proviceList);

		$new = [];
		foreach ($cityList as $key => $value)
		{
			$temp = '';

			if(isset($value['province']) && isset($proviceList[$value['province']]))
			{
				$temp .= $proviceList[$value['province']]. ' - ';
			}
			if(isset($value['localname']))
			{
				$temp .= $value['localname'];
			}
			$new[$key] = $temp;
		}
		asort($new);

		\dash\data::cityList($new);


	}
}
?>