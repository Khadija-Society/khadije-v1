<?php
namespace content_a\protection\detail;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Change request status"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$occasion_id = \dash\data::occasionID();

		$count = \lib\app\protectagentuser::occasion_list_count($occasion_id);

		\dash\data::userListCount($count);

	}

}
?>
