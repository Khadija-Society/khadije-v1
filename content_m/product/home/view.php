<?php
namespace content_m\product\home;


class view
{
	public static function config()
	{
		\dash\permission::access('mProductView');

		\dash\data::page_title(T_("products list"));

		\dash\data::page_pictogram('box');

		if(\dash\permission::check('mProductAdd'))
		{
			\dash\data::badge_link(\dash\url::this(). '/add');
			\dash\data::badge_text(T_('Add new product'));
		}


		$search_string            = \dash\request::get('q');
		if($search_string)
		{
			\dash\data::page_title(\dash\data::page_title(). ' | '. T_('Search for :search', ['search' => $search_string]));
		}

		$args =
		[
			'sort'  => \dash\request::get('sort'),
			'order' => \dash\request::get('order'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'desc';
		}

		if(\dash\request::get('status'))
		{
			$args['status'] = \dash\request::get('status');
		}


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\product::$sort_field, \dash\url::this());
		$dataTable = \lib\app\product::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['order']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>