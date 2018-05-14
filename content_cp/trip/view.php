<?php
namespace content_cp\trip;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Request list"));
		\dash\data::page_desc(T_("check request and update status of each request"));
		\dash\data::badge_link(\dash\url::here(). '/trip/options');
		\dash\data::badge_text(T_('Options'));

		$export_link = ' <a href="'. \dash\url::here(). '/trip?export=true">'. T_("Export"). '</a>';
		\dash\data::page_desc(\dash\data::page_desc(). $export_link);

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

		if(\dash\request::get('status')) $args['travels.status']           = \dash\request::get('status');
		if(\dash\request::get('type')) $args['travels.type']               = \dash\request::get('type');
		if(\dash\request::get('place')) $args['travels.place']             = \dash\request::get('place');
		if(\dash\request::get('gender')) $args['users.gender']             = \dash\request::get('gender');
		if(\dash\request::get('birthday')) $args['YEAR(users.birthday)'] = \dash\request::get('birthday');

		if(!isset($args['travels.status']))
		{
			$args['travels.status'] = ["NOT IN", "('cancel', 'draft')"];
		}

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

		\dash\data::tripList(\lib\app\travel::list($search_string, $args));

		if($export)
		{
			\dash\utility\export::csv(['name' => 'export_trip', 'data' => \dash\data::tripList()]);
		}

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\travel::$sort_field, \dash\url::here(). '/trip'));

	}
}
?>
