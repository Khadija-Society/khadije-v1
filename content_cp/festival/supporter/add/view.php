<?php
namespace content_cp\supporter\add;


class view
{
	public static function config()
	{
		\dash\permission::access('fpCourseAdd');

		\content_cp\supporter\load::festival();

		\dash\data::page_title(T_("Add new supporter"). ' | '. \dash\data::currentFestival_title());
		\dash\data::page_desc(T_("add new festival by some data and can edit it later"));
		\dash\data::badge_link(\dash\url::here(). '/supporter?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to supporter list'));


		if(\dash\request::get('supporter'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('supporter'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(T_("Edit supporter"). ' | '. \dash\data::currentFestival_title() . ' | '.  \dash\data::dataRow_title());
		}

		\dash\data::page_pictogram('plus');

		\dash\data::display_supporterAdd('content_cp/supporter/layout.html');


	}
}
?>
