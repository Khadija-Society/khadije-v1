<?php
namespace content_cp\representation;


class view
{
	public static function config()
	{
		\dash\permission::access('cpRepresentationView');

		\dash\data::page_title(T_("Representation request list"));
		\dash\data::page_desc(T_("check representation requests"));

		$export_link = ' <a href="'. \dash\url::here(). '/representation?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc() . $export_link);

		\dash\data::badge_link(\dash\url::here(). '/representation/options');
		\dash\data::badge_text(T_('Options'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('status')) $args['services.status'] = \dash\request::get('status');
		if(\dash\request::get('representation')) $args['services.expert'] = \dash\request::get('representation');
		$args['services.type'] = 'representation';


		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$export = false;
		if(\dash\request::get('export') === 'true')
		{
			$export = true;
			$args['pagenation'] = false;
		}

		\dash\data::dataTable(\lib\app\service::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_service', 'data' => \dash\data::dataTable()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\service::$sort_field, \dash\url::here(). '/service'));
		$filterArray = $args;
		unset($filterArray['services.type']);
		if(isset($filterArray['services.expert']))
		{
			$filterArray[T_("Representation")] = $filterArray['services.expert'];
			unset($filterArray['services.expert']);
		}
		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);
	}
}
?>
