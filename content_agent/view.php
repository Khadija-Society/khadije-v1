<?php
namespace content_agent;


class view
{
	public static function config()
	{
		// \dash\data::include_css(true);
		// \dash\data::include_js(true);
		\dash\data::include_adminPanel(true);
		\dash\data::include_highcharts(true);

		\dash\data::display_admin('content_agent/layout.html');
	}
}
?>
