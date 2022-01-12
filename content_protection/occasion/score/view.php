<?php
namespace content_protection\occasion\score;


class view
{
	public static function config()
	{

		\dash\data::page_title('امتیاز بندی نمایندگان بر اساس گزارش‌های دریافتی');

		\dash\data::page_pictogram('list');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$field_title = \lib\app\protectionagentoccasion::field_list();
		\dash\data::mediaTitle($field_title);

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
			'pagenation' => false,
		];

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\protectionagentoccasion::$sort_field, \dash\url::this());
		$dataTable = \lib\app\protectionagentoccasion::list(\dash\request::get('q'), $args);

		if(!is_array($dataTable))
		{
			$dataTable = [];
		}

		$report_score = 6;

		foreach ($dataTable as $key => $value)
		{
			$total_score = 0;
			foreach ($field_title as $k => $v)
			{
				if(mb_strlen(a($value, $k)) > 2)
				{
					$dataTable[$key]['score_'. $k] = $v['score'];
					$total_score += $v['score'];
				}
			}

			if(mb_strlen(a($value, 'report')) > 2)
			{
				$dataTable[$key]['score_report'] = $report_score;
				$total_score += $report_score;
			}


			$dataTable[$key]['total_score'] = $total_score;
		}

		$sort_column = array_column($dataTable, 'total_score');
		array_multisort($dataTable, SORT_NUMERIC, $sort_column, SORT_DESC);


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