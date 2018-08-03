<?php
namespace content_a\festival\mycourse;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Festival course list"));
		\dash\data::page_desc(T_('You can signup in some festival course'));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

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

		$my_course = \lib\db\festivalusers::get_full(['user_id' => \dash\user::id()]);
		\dash\data::myCourse($my_course);
	}
}
?>
