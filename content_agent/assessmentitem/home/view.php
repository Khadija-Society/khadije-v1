<?php
namespace content_agent\assessmentitem\home;


class view
{
	public static function config()
	{


		\dash\data::page_title(T_("assessmentitems list"));

		\dash\data::page_pictogram('box');

		$url_get            = [];
		$url_get['city']    = \dash\request::get('city');
		$url_get['job']     = \dash\request::get('job');
		$url_get['job_for'] = \dash\request::get('job_for');

		\dash\data::badge_link(\dash\url::this(). '/add?'. http_build_query($url_get));
		\dash\data::badge_text(T_('Add new assessmentitem'));



		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

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

		if(\dash\request::get('city'))
		{
			$city = \dash\request::get('city');

			$args['1.1'] =[' = 1.1 ', " AND ( city is null or city = '$city')"];
		}

		$args['4.4'] = [' = 4.4 ', " AND status != 'deleted' "];

		if(\dash\request::get('status'))
		{
			$status = \dash\request::get('status');

			$args['status'] = $status;
		}


		$job = \dash\request::get('job');
		if(!$job)
		{
			$job = 'adminoffice';
		}

		$job_for = \dash\request::get('job_for');

		$args['2.2'] = [' = 2.2 ', " AND ( job is null or job = '$job')"];
		$args['3.3'] = [' = 3.3 ', " AND ( job_for is null or job_for = '$job_for')"];


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\assessmentitem::$sort_field, \dash\url::this());
		$dataTable = \lib\app\assessmentitem::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['1.1']);
		unset($check_empty_datatable['2.2']);
		unset($check_empty_datatable['3.3']);
		unset($check_empty_datatable['4.4']);
		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['pagenation']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>