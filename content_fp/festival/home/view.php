<?php
namespace content_fp\festival\home;


class view
{
	public static function config()
	{
		\dash\permission::access('fpFestivalView');


		\dash\data::page_pictogram('list');

		\dash\data::page_title(T_("Festivals list"));
		\dash\data::page_desc(T_("check last festival and add or edit a festival"));

		$export_link = ' <a href="'. \dash\url::this(). '?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). $export_link);

		\dash\data::badge_link(\dash\url::this(). '/add');
		\dash\data::badge_text(T_('Add new festival'));
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

		\dash\data::dataTable(\dash\app\transaction::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::here(). '/donate'));

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
