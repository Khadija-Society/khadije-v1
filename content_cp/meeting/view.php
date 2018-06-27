<?php
namespace content_cp\meeting;


class view
{
	public static function config()
	{
		\dash\permission::access('cpMeeting');


		\dash\data::page_pictogram('gavel');

		\dash\data::page_title(T_("Meeting list"));
		\dash\data::page_desc(T_("check all meeting report"));

		if(\dash\permission::check('cpMeetingAdd'))
		{
			\dash\data::badge_link(\dash\url::this(). '/add');
			\dash\data::badge_text(T_('Add new meeting'));
		}

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

		$args['type'] = 'meeting';

		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		\dash\data::dataTable(\dash\app\posts::list($search_string, $args));

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\posts::$sort_field, \dash\url::here(). '/meeting'));

		$filterArray = $args;
		unset($filterArray['type']);

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);
	}
}
?>
