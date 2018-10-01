<?php
namespace content_cp;

class view
{
	public static function config()
	{
		\dash\data::display_cpMain('content_cp/layout.html');
		\dash\data::bodyclass('unselectable');

		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		\dash\data::include_editor(true);
	}
}
?>