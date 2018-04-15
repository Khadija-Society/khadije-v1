<?php
namespace content_a\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Khadije Dashboard"));
		\dash\data::page_desc(\dash\data::site_desc());
		\dash\data::dateDetail(\dash\date::month_precent());
	}
}
?>
