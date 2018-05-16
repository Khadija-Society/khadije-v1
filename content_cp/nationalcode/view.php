<?php
namespace content_cp\nationalcode;


class view
{
	public static function config()
	{
		\dash\permission::access('cpNationalCodeView');

		\dash\data::page_title(T_("National code list"));
		\dash\data::page_desc(T_("check nationalcode of persons and number of trips"));
		\dash\data::badge_link(\dash\url::here(). '/nationalcode/import');
		\dash\data::badge_text(T_('Import'));

		$export_link = ' <a href="'. \dash\url::here(). '/nationalcode?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). $export_link);

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];

		$search_string            = \dash\request::get('q');

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

		\dash\data::nationalcodeList(\lib\app\nationalcode::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::nationalcodeList()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\nationalcode::$sort_field, \dash\url::here(). '/nationalcode'));
	}
}
?>
