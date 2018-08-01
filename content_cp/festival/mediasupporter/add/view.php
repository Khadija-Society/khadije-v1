<?php
namespace content_cp\mediasupporter\add;


class view
{
	public static function config()
	{
		\dash\permission::access('fpCourseAdd');

		\content_cp\mediasupporter\load::festival();

		\dash\data::page_title(T_("Add new mediasupporter"). ' | '. \dash\data::currentFestival_title());
		\dash\data::page_desc(T_("add new festival by some data and can edit it later"));
		\dash\data::badge_link(\dash\url::here(). '/mediasupporter?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to mediasupporter list'));


		if(\dash\request::get('mediasupporter'))
		{
			$load = \lib\app\festivaldetail::get(\dash\request::get('mediasupporter'));
			if(!$load)
			{
				\dash\header::status(404, T_("Invalid id"));
			}
			\dash\data::dataRow($load);
			\dash\data::page_title(T_("Edit mediasupporter"). ' | '. \dash\data::currentFestival_title() . ' | '.  \dash\data::dataRow_title());
		}

		\dash\data::page_pictogram('plus');

		\dash\data::display_mediasupporterAdd('content_cp/mediasupporter/layout.html');


	}
}
?>
