<?php
namespace content_protection\occasiontype;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Occasion type"));


		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$dataTable = \lib\app\protectiontype::get_all_full('occasiontype');
		\dash\data::dataTable($dataTable);
	}

}
?>
