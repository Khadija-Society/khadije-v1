<?php
namespace content_fp;

class view
{
	public static function config()
	{
		\dash\data::display_cpMain('content_fp/layout.html');
		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::include_editor(true);
	}
}
?>