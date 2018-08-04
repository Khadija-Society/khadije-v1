<?php
namespace content_a\festival\request;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Festival course list"));
		\dash\data::page_desc(T_('You can signup in some festival course'));

		\dash\data::badge_link(\dash\url::this(). '/mycourse?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to my course list'));

		$id  = \dash\request::get('id');

		if(!$id || !is_numeric($id))
		{
			\dash\redirect::to(\dash\url::here());
		}

		$load = \lib\app\festival::get($id);

		if(!$load)
		{
			\dash\header::status(403, T_("Invalid festival id"));
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

		\dash\data::course($course);
	}
}
?>
