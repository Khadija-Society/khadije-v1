<?php
namespace content_fp\course\home;


class view
{
	public static function config()
	{
		\dash\permission::access('fpFestivalView');


		\dash\data::page_pictogram('list');

		\dash\data::page_title(T_("Festivals list"));
		\dash\data::page_desc(T_("check last festival and add or edit a festival"));

		\dash\data::badge_link(\dash\url::here(). '/festival');
		\dash\data::badge_text(T_('Festivals list'));
		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'dateverify';
		}

		$search_string     = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$export = false;
		if(\dash\request::get('export') === 'true')
		{
			$export             = true;
			$args['pagenation'] = false;
		}

		$dataTable = \lib\app\festival::list($search_string, $args);

		\dash\data::dataTable($dataTable);

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\festival::$sort_field, \dash\url::this()));

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
