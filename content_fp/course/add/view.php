<?php
namespace content_fp\course\add;


class view
{
	public static function config()
	{
		\dash\permission::access('fpCourseAdd');

		\content_fp\course\load::festival();

		if(\dash\request::get('course'))
		{
			$load = \lib\app\festivalcourse::get(\dash\request::get('id'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
		}

		\dash\data::page_pictogram('plus');

		\dash\data::display_courseAdd('content_fp/course/layout.html');

		\dash\data::page_title(T_("Add new course"). ' | '. \dash\data::currentFestival_title());
		\dash\data::page_desc(T_("add new festival by some data and can edit it later"));
		\dash\data::badge_link(\dash\url::here(). '/festival');
		\dash\data::badge_text(T_('Back to festival list'));

	}
}
?>
