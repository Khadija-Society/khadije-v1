<?php
namespace content_cp\smsapp\listsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Edit filter sms group"));
		\dash\data::page_desc(T_("You cat set some filter to group"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Dashboard'));


		$filterArray = [];

		$args =
		[
			'order' => \dash\request::get('order'),
			'sort'  => \dash\request::get('sort'),
		];

		$search_string = \dash\request::get('q');

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(\dash\request::get('status'))
		{
			$args['status']     = \dash\request::get('status');
			$filterArray['status'] = \dash\request::get('status');
		}

		if(\dash\request::get('type'))
		{
			$args['type']     = \dash\request::get('type');
			$filterArray['type'] = \dash\request::get('type');
		}

		$dataTable = \lib\app\sms::list($search_string, $args);

		\dash\data::dataTable($dataTable);

		\dash\data::sortLink(\content_cp\view::make_sort_link(\lib\app\sms::$sort_field, \dash\url::that()));

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);


	}
}
?>
