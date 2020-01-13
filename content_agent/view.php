<?php
namespace content_agent;


class view
{
	public static function config()
	{
		\dash\data::include_css(true);
		\dash\data::include_js(true);
		\dash\data::include_adminPanel(true);
	}
}
?>
