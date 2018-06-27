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

		if(\dash\request::get('status')) $args['posts.status'] = \dash\request::get('status');

		$args['posts.type'] = 'meeting';

		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}


		\dash\data::dataTable(self::meeting_list($search_string, $args));

		// $filterArray = $args;
		// unset($filterArray['type']);

		// // set dataFilter
		// $dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		// \dash\data::dataFilter($dataFilter);
	}

	public static function meeting_list($_string = null, $_options = [])
	{

		$default_option =
		[
			'search_field'      => " ( posts.title LIKE '%__string__%' ) ",
			'public_show_field' => " posts.*, users.* ",
			'master_join'       => " INNER JOIN users ON users.id = posts.user_id ",
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('posts', $_string, $_options);
		if(is_array($result))
		{
			$result = array_map(["\dash\app\user", "ready"], $result);
		}
		return $result;
	}
}
?>
