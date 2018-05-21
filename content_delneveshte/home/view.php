<?php
namespace content_delneveshte\home;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Heart Writing"));
		\dash\data::page_desc(\dash\data::site_desc());
		\dash\data::include_css(false);
		\dash\data::include_js(false);
	}
}
?>
