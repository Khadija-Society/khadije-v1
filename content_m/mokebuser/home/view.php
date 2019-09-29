<?php
namespace content_m\mokebuser\home;

class view
{

	public static function config()
	{
		\dash\permission::access('cpUsersKarbalaView');
		\dash\data::page_pictogram('users');
		\dash\data::page_title(T_('List of users'));
		\dash\data::page_desc(T_('Some detail about your users!'));
		\dash\data::page_desc(T_('Check list of users and search or filter in them to find your user.'));
		\dash\data::page_desc(\dash\data::page_desc(). ' '. T_('Also add or edit specefic user.'));

		\dash\data::badge_text(T_('Report'));
		\dash\data::badge_link(\dash\url::this(). '/report');



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

		$sortLink = \content_m\view::make_sort_link(\dash\app\user::$sort_field, \dash\url::this());
		$dataTable = \lib\db\mokebusers::search(\dash\request::get('q'), $args);
		if(is_array($dataTable))
		{
			$dataTable = array_map(["\\lib\\app\\karbalauser", "ready"], $dataTable);
		}


		\dash\data::sortLink($sortLink);
		\dash\data::dataTable($dataTable);

		$check_empty_datatable = $args;
		unset($check_empty_datatable['sort']);
		unset($check_empty_datatable['order']);

		// set dataFilter
		$dataFilter = \content_m\view::createFilterMsg($search_string, $check_empty_datatable);
		\dash\data::dataFilter($dataFilter);


	}
}
?>