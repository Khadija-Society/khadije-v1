<?php
namespace content_fp\referee\add;


class view
{
	public static function config()
	{
		\dash\permission::access('fpCourseAdd');

		\content_fp\referee\load::festival();

		\dash\data::page_title(T_("Add new referee"). ' | '. \dash\data::currentFestival_title());
		\dash\data::page_desc(T_("add new festival by some data and can edit it later"));
		\dash\data::badge_link(\dash\url::here(). '/referee?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to referee list'));


		if(\dash\request::get('referee'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('referee'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(T_("Edit referee"). ' | '. \dash\data::currentFestival_title() . ' | '.  \dash\data::dataRow_title());
		}

		\dash\data::page_pictogram('plus');

		\dash\data::display_refereeAdd('content_fp/referee/layout.html');


	}
}
?>
