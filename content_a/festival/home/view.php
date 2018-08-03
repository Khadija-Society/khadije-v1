<?php
namespace content_a\festival\home;


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

		$course = \lib\db\festivalcourses::get(['festival_id' => $festival_id, 'status' => 'enable']);
		if(is_array($course))
		{
			$course = array_map(['\lib\app\festivalcourse', 'ready'], $course);
		}

		\dash\data::course($course);

	}
}
?>
