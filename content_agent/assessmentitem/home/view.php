<?php
namespace content_agent\assessmentitem\home;


class view
{
	public static function config()
	{
		\dash\permission::access('ContentMokebAddAssessmentitem');

		\dash\data::page_title(T_("assessmentitems list"));

		\dash\data::page_pictogram('box');

		if(\dash\permission::check('mAssessmentitemAdd'))
		{
			\dash\data::badge_link(\dash\url::this(). '/add');
			\dash\data::badge_text(T_('Add new assessmentitem'));
		}


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

		if(\dash\request::get('status'))
		{
			$args['status'] = \dash\request::get('status');
		}


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\assessmentitem::$sort_field, \dash\url::this());
		$dataTable = \lib\app\assessmentitem::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['pagenation']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>