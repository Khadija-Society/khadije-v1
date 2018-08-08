<?php
namespace content_a\festival\request;


class view
{
	public static function config()
	{
		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));
		$complete_profile = \dash\data::userdetail_iscompleteprofile();
		if(intval($complete_profile) === 0)
		{
			\dash\redirect::to(\dash\url::this(). '/profile?'. http_build_query(\dash\request::get()));
		}

		\dash\data::page_title(T_("Festival course list"));
		\dash\data::page_desc(T_('You can signup in some festival course'));

		\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to my course list'));


		self::load_course();
	}


	public static function load_course()
	{
		$id  = \dash\request::get('id');

		if(!$id)
		{
			\dash\redirect::to(\dash\url::here());
		}

		$load = \lib\app\festival::get($id);

		if(!$load)
		{
			\dash\header::status(403, T_("Invalid festival id"));
		}

		if(\dash\session::get('userCompleteCourse'))
		{
			if(isset($load['message']))
			{
				\dash\data::showMSG($load['message']);
			}
			\dash\session::set('userCompleteCourse', null);
		}

		$festival_id = \dash\coding::decode($id);

		$course = \dash\request::get('course');
		$course = \lib\app\festivalcourse::get($course);

		if(!$course)
		{
			\dash\header::status(404, T_("Invalid course id"));
		}

		$check_duplicate = \content_a\festival\course\model::check_duplicate(\dash\coding::decode(\dash\request::get('course')));
		if(!$check_duplicate)
		{
			\dash\header::status(403, T_("You not register to this course!"));
		}

		if(isset($check_duplicate['file']))
		{
			$check_duplicate['file'] = json_decode($check_duplicate['file'], true);
		}

		\dash\data::dataRow($check_duplicate);

		\dash\data::course($course);
	}
}
?>
