<?php
namespace content_a\donate\product;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Khadije Dashboard"));
		\dash\data::page_desc(\dash\data::site_desc());

		\dash\data::need(\lib\app\need::list('product'));
		\dash\data::wayList(\lib\app\donate::way_list());
	}
}
?>
