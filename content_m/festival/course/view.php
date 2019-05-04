<?php
namespace content_m\festival\course;


class view
{
	public static function config()
	{
		\dash\data::display_festivalCourseDisplay('content_m/festival/course/list.html');

		\dash\data::badge_link(\dash\url::this(). '/course?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to course list'));

		if(\dash\request::get('type') === 'add')
		{
			\dash\permission::access('cpFestivalCourseAdd');

			\dash\data::display_festivalCourseDisplay('content_m/festival/course/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Add new course"));
			\dash\data::page_desc(T_("Add new course by some detail"));
			\dash\data::page_pictogram('plus');
			\dash\data::groupList(\lib\app\festival::group_list(\dash\request::get('id')));
		}
		elseif(\dash\request::get('course'))
		{
			$dataRow = \lib\app\festivalcourse::get(\dash\request::get('course'));
			if(!$dataRow)
			{
				\dash\header::status(404, T_("Invalid course id"));
			}
			\dash\data::dataRow($dataRow);

			\dash\permission::access('cpFestivalCourseEdit');

			\dash\data::display_festivalCourseDisplay('content_m/festival/course/add.html');
			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. \dash\data::dataRow_title(). ' | ' .T_("Edit course"));
			\dash\data::page_desc(T_("Edit course"). '| '. \dash\data::dataRow_title());
			\dash\data::page_pictogram('edit');

			\dash\data::groupList(\lib\app\festival::group_list(\dash\request::get('id')));
		}
		else
		{
			\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
			\dash\data::badge_text(T_('Back to dashboard'));

			\dash\permission::access('cpFestivalCourseView');

			\dash\data::page_pictogram('arrows-alt');

			\dash\data::page_title(\dash\data::currentFestival_title(). ' | '. T_("Course list"));

			\dash\data::page_desc(T_("check festival course and add or edit a course"));

			$args                = [];
			$args['festival_id'] = \dash\coding::decode(\dash\request::get('id'));
			$args['pagenation']  = false;

			$dataTable = \lib\app\festivalcourse::list(null, $args);

			\dash\data::dataTable($dataTable);
		}
	}

}
?>
