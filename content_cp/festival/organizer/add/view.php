<?php
namespace content_cp\organizer\add;


class view
{
	public static function config()
	{
		\dash\permission::access('fpCourseAdd');

		\content_cp\organizer\load::festival();

		\dash\data::page_title(T_("Add new organizer"). ' | '. \dash\data::currentFestival_title());
		\dash\data::page_desc(T_("add new festival by some data and can edit it later"));
		\dash\data::badge_link(\dash\url::here(). '/organizer?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to organizer list'));


		if(\dash\request::get('organizer'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('organizer'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(T_("Edit organizer"). ' | '. \dash\data::currentFestival_title() . ' | '.  \dash\data::dataRow_title());
		}

		\dash\data::page_pictogram('plus');

		\dash\data::display_organizerAdd('content_cp/organizer/layout.html');


	}
}
?>
