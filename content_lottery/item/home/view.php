<?php
namespace content_lottery\item\home;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Lottery list"));

		\dash\data::page_pictogram('box');


		\dash\data::badge_link(\dash\url::this(). '/add' . \dash\data::xTypeStart());
		\dash\data::badge_text(T_('Add new Lottery'));



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

		if(\dash\request::get('type'))
		{
			$args['type'] = \dash\request::get('type');
		}


		$sortLink  = \dash\app\sort::make_sortLink(\lib\app\syslottery::$sort_field, \dash\url::this());
		$dataTable = \lib\app\syslottery::list(\dash\request::get('q'), $args);

		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['order']);
		unset($check_empty_datatable['pagenation']);
		unset($check_empty_datatable['type']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>