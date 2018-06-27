<?php
namespace content_cp\meeting;


class view
{
	public static function config()
	{

		\dash\data::page_pictogram('gavel');

		\dash\data::page_title(T_("Meeting list"));
		\dash\data::page_desc(T_("check all meeting report"));

		if(\dash\permission::check('cpMeeting'))
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

		if(!\dash\permission::check('cpMeetingManage'))
		{
			$args['posts.user_id'] = \dash\user::id();
		}

		$user = \dash\request::get('user');

		if($user && $user = \dash\coding::decode($user))
		{
			$args['posts.user_id'] = $user;
		}

		$args['posts.type'] = 'meeting';
		$args['limit']      = 3;

		$search_string            = \dash\request::get('q');

		if(!$search_string) $search_string = null;

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}


		\dash\data::dataTable(self::meeting_list($search_string, $args));

		$filterArray = $args;
		unset($filterArray['posts.type']);
		unset($filterArray['limit']);
		if(isset($filterArray['posts.user_id']))
		{
			$filterArray[T_("User")] = \dash\coding::encode($filterArray['posts.user_id']);
			unset($filterArray['posts.user_id']);
		}

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);
	}

	public static function meeting_list($_string = null, $_options = [])
	{

		$default_option =
		[
			'search_field'      =>
			"
				(
					posts.title LIKE '%__string__%' OR
					posts.subtitle LIKE '%__string__%'
				)
			 ",
			'public_show_field' => " posts.*, users.displayname, users.avatar, users.firstname, users.lastname, users.title AS `user_title`, users.mobile",
			'master_join'       => " INNER JOIN users ON users.id = posts.user_id ",
		];

		$_options = array_merge($default_option, $_options);
		$result = \dash\db\config::public_search('posts', $_string, $_options);
		if(is_array($result))
		{
			$result = array_map(["\dash\app\user", "ready"], $result);
			foreach ($result as $key => $value)
			{
				if(isset($value['content']))
				{
					$x = self::enter_to_space($value['content']);
					$x = strip_tags($x);
					$result[$key]['content_raw'] = $x;
				}

				if(isset($value['meta']))
				{
					if(is_string($value['meta']))
					{
						$value['meta'] = json_decode($value['meta'], true);
					}
					if(isset($value['meta']['member']))
					{
						$result[$key]['meta']['member_array'] = explode(',', $value['meta']['member']);
					}
				}
			}
		}

		return $result;
	}


	public static function enter_to_space($_data)
	{
		$_data = str_replace("</", " </", $_data);
		$_data = str_replace("\n", " ", $_data);
		$_data = str_replace("<br>", " ", $_data);
		$_data = trim($_data);
		return $_data;
	}
}
?>
