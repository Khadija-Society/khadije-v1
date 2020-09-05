<?php
namespace content_a\protection\occasion;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Record the information of the people covered"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$occasion_id = \dash\request::get('id');


		$list = \lib\app\protectagentuser::occasion_list($occasion_id);
		\dash\data::userOccasionList($list);

	}

}
?>
